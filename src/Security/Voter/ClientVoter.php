<?php

namespace App\Security\Voter;

use App\Entity\Client;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['SHOW','EDIT', 'DELETE'])
            && $subject instanceof Client;
    }

    protected function voteOnAttribute($attribute, $client, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'SHOW':
                return $client->getuser()->getId() === $user->getId();
                break;
            case 'EDIT':
                return $client->getuser()->getId() === $user->getId();
                break;
            case 'DELETE':
                return $client->getuser()->getId() === $user->getId();
                break;
        }

        return false;
    }
}
