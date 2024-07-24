<?php

namespace App\Http\Controllers;

use App\Events\SetBudget;
use App\Models\Budget;
use App\Models\User;
use App\Notifications\SetBudgetNotification;
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
        // event(new SetBudget($request->ammount));
        auth()->user()->notify(new SetBudgetNotification($request->amount));
        return redirect()->route('expenses.index');
    }
}
