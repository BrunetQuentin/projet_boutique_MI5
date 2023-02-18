<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SecuriteController extends AbstractController
{
    public function login(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('compteDetail');
        }

        // redirect to compte/connexion if not logged
        return $this->redirectToRoute('compteConnexion');
    }
    public function logout(): Response
    {
        return $this->redirectToRoute('boutique');
    }
}
