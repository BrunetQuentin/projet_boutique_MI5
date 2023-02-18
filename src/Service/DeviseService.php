<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeviseService {

    const CURRENCIES = 'currencies';
    const ACTIVE_CURRENCY = 'active_currency';

    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

        // set active currency to EUR if not set
        if ($this->session->get(self::ACTIVE_CURRENCY) == null) {
            $this->session->set(self::ACTIVE_CURRENCY, 'EUR');
        }

        $quotes = [
            'EURUSD' => 1.0617,
            'EUREUR' => 1,
            'EURGBP' => 0.8872,
            'EURAUD' => 1.5510,
            'EURCAD' => 1.4243,
            'EURSGD' => 1,4276,
        ];
        $this->session->set(self::CURRENCIES, $quotes);
    }

    // convert euros to active currency
    public function convert(float $amount): float
    {
        $currencies = $this->session->get(self::CURRENCIES);

        $activeCurrency = $this->getActiveCurrency();

        $key = 'EUR' . $activeCurrency;

        if (array_key_exists($key, $currencies)) {
            return $amount * $currencies[$key];
        }

        return $amount;
    }

    public function getActiveCurrency(): string
    {
        return $this->session->get(self::ACTIVE_CURRENCY, 'EUR');
    }

    public function setActiveCurrency(string $newCurrency): void
    {
        $this->session->set(self::ACTIVE_CURRENCY, $newCurrency);
    }

}
