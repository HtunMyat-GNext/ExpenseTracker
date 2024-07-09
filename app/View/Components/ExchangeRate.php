<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;

class ExchangeRate extends Component
{
    public $rates;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->rates = $this->getExchangeRate();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.exchange-rate');
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
