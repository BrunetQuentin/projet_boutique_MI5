<?php
// src/Controller/MailerController.php
namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    public function commande(MailerInterface $mailer)
    {
        $user = $this->getUser();

        $commande = $user->getCommandes();

        $email = (new TemplatedEmail())
            ->from('test@Legion.lan')
            ->to($user->getEmail())
            ->subject('Projet symfony - Commande validée')
            ->htmlTemplate('compte/mesCommandes.html.twig');

        $mailer->send($email);

        return $this->redirectToRoute('boutique');
    }
}
