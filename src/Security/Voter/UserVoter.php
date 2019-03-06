<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['GET', 'DELETE'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute($attribute, $user, TokenInterface $token)
    {
        $client = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$client instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'GET':
                return $user->getClient()->getId() == $client->getId();
                break;
            case 'DELETE':
                return $user->getClient()->getId() == $client->getId();
                break;
        }

        return false;
    }
}
