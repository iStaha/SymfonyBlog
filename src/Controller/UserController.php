<?php
/**
 * Created by PhpStorm.
 * User: Staha
 * Date: 18-Jan-19
 * Time: 12:34 PM
 */

namespace App\Controller;

use App\Entity\User;

use App\Form\RoleType;
use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/user")
 */


class UserController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;


    /**
     * @var \Twig_Environment
     */
    private $twig;


    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        \Twig_Environment $twig,
        FormFactoryInterface $formFactory, EntityManagerInterface $entityManager,
        RouterInterface $router
    )
    {


        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->router = $router;

    }






    /**
     * @Route("/edit/{id}" , name="user_edit")
     */

    public function edit(User $user , Request $request){


        $form = $this->formFactory->create(RoleType::class, $user);

        $form->handleRequest($request);



        if( $form->isSubmitted()  &&  $form->isValid() ){
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }
        return new Response(
            $this->twig->render('micro-post/roles.html.twig', ['form' => $form->createView()] )
        );
    }

}