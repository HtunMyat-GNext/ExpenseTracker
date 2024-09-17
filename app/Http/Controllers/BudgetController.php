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
        $user_id = $this->getUser_id($request);
        $budget = Budget::where('user_id', $user_id)->first();
        $this->saveBudget($budget, $request, $user_id);
        auth()->user()->notify(new SetBudgetNotification($request->amount));
        return redirect()->route('expenses.index');
    }

    /**
     * @param $budget
     * @param Request $request
     * @param int|null $user_id
     * @return void
     */
    public function saveBudget($budget, Request $request, ?int $user_id): void
    {
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
    }

    /**
     * @param Request $request
     * @return int|null
     */
    public function getUser_id(Request $request): ?int
    {
        $user_id = User::getCurrentUserId();
        $request->validate([
            'amount' => 'required|integer'
        ]);
        return $user_id;
    }
}
