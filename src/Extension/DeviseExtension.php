<?php

namespace App\Extension;

use App\Service\DeviseService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DeviseExtension extends AbstractExtension
{
    private DeviseService $deviseService;

    public function __construct(DeviseService $deviseService)
    {
        $this->deviseService = $deviseService;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('devise', [$this, 'formatDevise']),
        ];
    }

    // define a twig function to return the curent devise
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('getDevise', [$this, 'getDevise']),
        ];
    }

    public function getDevise()
    {
        return $this->deviseService->getActiveCurrency();
    }

    public function formatDevise($euro)
    {
        $price = $this->deviseService->convert($euro);

        return $price;
    }
}
