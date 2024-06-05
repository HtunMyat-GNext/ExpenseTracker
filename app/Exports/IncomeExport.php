<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncomeExport implements FromView, ShouldAutoSize
{
    public function view(): View {
        // get income data by loign user id
        $user_id = auth()->user()->id;
        // get income data
        $incomes = Income::where('user_id', $user_id)->get();
        // sum total amount to display in excel
        $total_amount = $incomes->sum('amount');
        // return to export view file 
        return view('income.exports.excel', compact('incomes', 'total_amount'));
    }
}
