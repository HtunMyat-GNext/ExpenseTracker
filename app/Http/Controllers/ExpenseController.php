<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

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
        // dd($request->all());
        $user_id = Auth::user()->id;
        $imageName = '';
        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        Expense::create([
            'name'  =>  $request->name,
            'user_id'   => $user_id,
            'date'  => $request->date,
            // 'category_id' => 1,
            'img' =>  $imageName != '' ? 'images/' . $imageName : '',
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        // dd('edit', $id);
        return view('expenses.edit', compact('expense'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {

        // dd($expense);
        // dd($request->all());


        $expense->update($request->except('image'));

        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $expense->update([
                'img' => 'images/' . $imageName,
            ]);
        }
        return redirect()->route('expenses.index');
    }

    // public function show()
    // {
    //     dd('show');
    // }

    public function destroy(Expense $expense)
    {
        // dd('delete');
        dd($expense);
        $expense->delete();
        return redirect()->route('expenses.index');
    }
}
