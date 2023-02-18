<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeviseService
{

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

        $json = file_get_contents("http://api.currencylayer.com/live?access_key=f9b2a7f42757db9e3643c27084c64385&currencies=EUR,CAD,USD,GBP,PHP,IDR&format=1");
        $object = json_decode($json);

        $quotes = [];

        if ($object->success) {
            // transform $object->quotes Object to array
            $quotes = (array) $object->quotes;
        } else {
            $quotes = [
                "USDEUR" => 0.932804,
                "USDCAD" => 1.34755,
                "USDGBP" => 0.830289,
                "USDPHP" => 55.525039,
                "USDIDR" => 15166
            ];
        }
        $this->session->set(self::CURRENCIES, $quotes);
    }

    // convert euros to active currency
    public function convert(float $amountInEuro): float
    {
        $currencies = $this->session->get(self::CURRENCIES);

        dump($currencies);

        // convert euro to usd
        $amountInUsd = $amountInEuro / $currencies['USDEUR'];

        $activeCurrency = $this->getActiveCurrency();

        $key = 'USD' . $activeCurrency;

        if (array_key_exists($key, $currencies)) {
            return $amountInUsd * $currencies[$key];
        }

        return $amountInUsd;
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
