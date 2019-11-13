<?php
// src/Security/PostVoter.php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{
    // these strings are just invented: you can use anything
    const DELETE = 'delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::DELETE])) {
            return false;
        }

        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(User $subject, $user)
    {
        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if($user === $subject) {
            return true;
        }

        return false;
    }
}
