<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib3\Crypt\EC;

class BudgetController extends Controller
{
    public function store(Request $request)
    {
        $user_id = User::getCurrentUserId();
        $request->validate([
            'amount' => 'required|integer'
        ]);
        $budget = Budget::where('user_id', $user_id)->first();
        if ($budget) {
            $budget->update([
                'amount' => $request->amount
            ]);
        } else {
            Budget::create([
                'user_id' => $user_id,
                'amount' => $request->amount
            ]);
        }
        return redirect()->route('expenses.index');
    }
}