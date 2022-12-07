<?php
    namespace App\Controller;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use App\Service\BoutiqueService; 
    class DefaultController extends AbstractController {
        public function index(BoutiqueService $boutique) {
            return $this->render('base.html.twig',[]);
        }
    }