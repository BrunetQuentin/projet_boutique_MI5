<?php
    namespace App\Controller;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use App\Service\BoutiqueService; 
    class AccueilController extends AbstractController {
        public function acceuil(BoutiqueService $boutique) {
            return $this->render('accueil.html.twig',[]);
        }
    }