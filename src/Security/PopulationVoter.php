<?php

namespace App\Security;

use App\Entity\Population;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class PopulationVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // these strings are just invented: you can use anything
    const DELETE = 'DELETE';
    const EDIT = 'EDIT';

    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Population) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // ROLE_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }        

        // you know $subject is a Population object, thanks to `supports()`
        /** @var Population $population */
        $population = $subject;

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($population, $user);
            case self::EDIT:
                return $this->canEdit($population, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Population $population, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($population, $user)) {
            return true;
        }

        // the Post object could have, for example, a method `isPrivate()`
        // return !$population->isPrivate();
    }

    private function canEdit(Population $population, User $user)
    {
        // this assumes that the Post object has a `getOwner()` method
        return $user === $population->getDoctor();
    }
}