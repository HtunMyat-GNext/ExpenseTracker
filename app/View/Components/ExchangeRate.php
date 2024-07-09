<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

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
        $exchangeRate = file_get_contents('https://forex.cbm.gov.mm/api/latest');
        $exchangeRate = json_decode($exchangeRate, true);
        return $exchangeRate['rates'];
    }
}
