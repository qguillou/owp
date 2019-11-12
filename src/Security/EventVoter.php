<?php
// src/Security/PostVoter.php
namespace App\Security;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class EventVoter extends Voter
{
    // these strings are just invented: you can use anything
    const REGISTER = 'register';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::REGISTER])) {
            return false;
        }

        if (!$subject instanceof Event) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $event, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::REGISTER:
                return $this->canRegister($event, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canRegister(Event $event, User $user)
    {
        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if($event->getAllowEntries() && $event->getDateEntries() > date('Y-m-d')) {
            return true;
        }

        return false;
    }
}
