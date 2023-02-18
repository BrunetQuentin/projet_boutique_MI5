<?php

namespace App\Controller;

use App\Service\DeviseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviseController extends AbstractController
{
    public function index(DeviseService $deviseService, string $devise)
    {
        $deviseService->setActiveCurrency($devise);

        $request = $this->get('request_stack')->getCurrentRequest();
        return $this->redirect($request->headers->get('referer'));
    }
}
