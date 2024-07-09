<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class ExchangeController extends Controller
{
    public function index()
    {
        $rates = $this->getExchangeRate();
        return view('exchange', compact('rates'));
    }

    private function getExchangeRate()
    {
        $cacheKey = 'exchange_rates';
        $exchangeRate = Cache::remember($cacheKey, now()->addHours(8), function () {
            return file_get_contents('https://forex.cbm.gov.mm/api/latest');
        });
        $exchangeRate = json_decode($exchangeRate, true);
        return $exchangeRate['rates'];
    }
}
