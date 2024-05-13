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
        Expense::create([
            'name'  =>  $request->name,
            'user_id'   => $request->user_id,
        ]);
    }

    public function edit($id)
    {
        dd('edit', $id);
    }

    public function update()
    {
        dd('update');
    }

    public function destroy($id)
    {
        dd('delete');
    }
}
