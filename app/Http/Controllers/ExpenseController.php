<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{


    public function index()
    {
        $expenses = Expense::all();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        // dd('this is create');
        return view('expenses.create');
    }

    public function store(StoreExpenseRequest $request)
    {
        dd($request->all());
    }
}
