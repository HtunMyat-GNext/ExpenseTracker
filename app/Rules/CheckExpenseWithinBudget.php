<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Support\Carbon;

class CheckExpenseWithinBudget implements Rule
{
    protected $userId;
    protected $amount;

    public function __construct($userId, $amount)
    {
        $this->userId = $userId;
        $this->amount = $amount;
    }

    public function passes($attribute, $value)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $total_expense = Expense::where('user_id', $this->userId)->whereMonth('date', $currentMonth)->whereYear('date', $currentYear)->sum('amount');
        $budget = Budget::where('user_id', $this->userId)->sum('amount');
        if ($budget) {
            return ($total_expense + $value) <= $budget;
        }
        return false;
    }

    public function message()
    {
        return 'The total expenses exceed your budget for this amount.';
    }
}
