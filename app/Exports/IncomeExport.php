<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncomeExport implements FromView, ShouldAutoSize
{
    private $incomes;
    private $total_amount;

    /**
     * Create a new instance of IncomeExport.
     *
     * @param array $incomes The income data to export.
     * @param float $total_amount The total amount of incomes.
     */

    public function __construct($incomes, $total_amount)
    {
        $this->incomes = $incomes;
        $this->total_amount = $total_amount;
    }

    public function view(): View
    {
        $incomes = $this->incomes;
        $total_amount = $this->total_amount;
        // return to export view file 
        return view('income.exports.excel', compact('incomes', 'total_amount'));
    }
}
