<?php

namespace App\Security\Voter;

use App\Entity\Cuestionario;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CuestionarioVoter extends Voter
{
    // Defining these constants is overkill for this simple application, but for real
    // applications, it's a recommended practice to avoid relying on "magic strings"
    public const DELETE = 'delete';
    public const EDIT = 'edit';
    public const SHOW = 'show';

    protected function supports($attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::SHOW, self::EDIT, self::DELETE], true)
            && $subject instanceof Cuestionario;

    }

    /**
     * @param string $attribute
     * @param mixed $cuestionario
     * @param TokenInterface $token
     * @return false
     */
    protected function voteOnAttribute($attribute, $cuestionario, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::DELETE:
            case self::SHOW:
            case self::EDIT:
                return $user === $cuestionario->getAutor();
                break;
        }

        return false;
    }
}
