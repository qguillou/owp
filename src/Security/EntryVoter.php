<?php
// src/Security/PostVoter.php
namespace App\Security;

use App\Entity\Entry;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class EntryVoter extends Voter
{
    // these strings are just invented: you can use anything
    const UPDATE = 'update';
    const DELETE = 'delete';
    const ADD    = 'add';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::DELETE, self::UPDATE, self::ADD])) {
            return false;
        }

        if (!$subject instanceof Entry) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $entry, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($entry, $user);
            case self::UPDATE:
                return $this->canUpdate($entry, $user);
            case self::ADD:
                return $this->canAdd($entry, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Entry $entry, User $user)
    {
        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($entry->getEvent()->getDateEntries()->format('U') > date('U')) {
            return true;
        }


        if ($entry->getCreateBy() === $user && $entry->contains($user->getBase())) {
            return true;
        }

        return false;
    }

    private function canUpdate(Entry $entry, User $user)
    {
        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($entry->getEvent()->getDateEntries()->format('U') > date('U')) {
            return true;
        }


        if ($entry->getCreateBy() == $user && $entry->contains($user->getBase())) {
            return true;
        }

        return false;
    }
}
