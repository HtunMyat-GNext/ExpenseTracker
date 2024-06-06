<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExpensesExport implements FromView
{
    private $start_date;
    private $end_date;
    private $expenses;


    public function __construct($start_date, $end_date, $expenses)
    {

        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->expenses = $expenses;
    }

    public function view(): View
    {
        // get income data by loign user id
        $user_id = auth()->user()->id;
        // get income data
        $expenses = Expense::where('user_id', $user_id)->get();
        // sum total amount to display in excel
        $total_amount = $expenses->sum('amount');
        // dd($total_amount . 'haha');
        // return to export view file
        return view('expenses.exports.excel', compact('expenses', 'total_amount'));
    }
}
