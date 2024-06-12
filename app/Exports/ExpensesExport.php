<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExpensesExport implements FromView, ShouldAutoSize
{
    private $expenses;
    private $total_amount;

    /**
     * Create a new instance of IncomeExport.
     *
     * @param array $expenses The income data to export.
     * @param float $total_amount The total amount of expenses.
     */

    public function __construct($expenses, $total_amount)
    {
        $this->expenses = $expenses;
        $this->total_amount = $total_amount;
    }

    public function view(): View
    {
        $expenses = $this->expenses;
        $total_amount = $this->total_amount;
        // return to export view file
        return view('expenses.exports.excel', compact('expenses', 'total_amount'));
    }
}
