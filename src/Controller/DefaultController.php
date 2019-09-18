<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

class DefaultController extends AbstractController
{
    public function index(MailerInterface $mailer)
    {
        $message = (new TemplatedEmail())
            ->from('romaric.drigon@gmail.com')
            ->to('user@example.com')
            ->subject('Test e-mail')
            ->htmlTemplate('mail.html.twig')
            ->textTemplate('mail.txt.twig')
        ;

        $mailer->send($message);

        return new Response('OK');
    }
}
