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
        return in_array($attribute, ['LIST','SHOW','EDIT', 'DELETE'])
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
            case 'LIST':
                //
                break;
            case 'SHOW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case 'EDIT':
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case 'DELETE':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
