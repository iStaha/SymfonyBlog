<?php

namespace App\Event;


use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $defaultLocale;

    public function __construct(
        Mailer $mailer

    ) {
        $this->mailer = $mailer;


    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister',
        ];
    }

    public function onUserRegister(UserRegisterEvent $event)
    {

        /*$body = $this -> twig -> render('email/registration.html.twig' , [
            'user'  =>  $event -> getRegisteredUser()
        ]);
        $message = (new \Swift_Message())
                     ->setSubject('Welcome to the micropost app!')
                     ->setFrom('micropost@micropost.com')
                     ->setTo($event->getRegisteredUser()->getEmail())
                     ->setBody($body, 'text/html');


         $this->mailer->send($message);*/

        $this->mailer->sendConfirmationEmail($event->getRegisteredUser());


    }
}