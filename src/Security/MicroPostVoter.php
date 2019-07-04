<?php

namespace  App\Security;
use App\Controller\MicroPostController;
use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Created by PhpStorm.
 * User: Staha
 * Date: 11-Jan-19
 * Time: 12:34 PM
 */

class MicroPostVoter extends Voter
{

    const EDIT = 'edit';
    const DELETE = 'delete';
    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    public  function __construct(AccessDecisionManagerInterface $decisionManager)
    {

        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // TODO: Implement supports() method.
        if(!in_array($attribute , [self::EDIT , self::DELETE])){
             return false;
        }

        if(! $subject instanceof MicroPost){
             return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // TODO: Implement voteOnAttribute() method.

        if($this -> decisionManager ->decide($token , [User::ROLE_ADMIN])){
            return true;
        }

        $authenticatedUser = $token -> getUser();

        if(! $authenticatedUser instanceof User){
                return false;
        }

        /** @var  MicroPost $micropost */
        $micropost = $subject;


         return $micropost->getUser()->getId() == $authenticatedUser->getId();


    }
}