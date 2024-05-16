<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Models\Income;

class IncomeController extends Controller
{
    /**
     * show index page
     */
    public function index() {
        $incomes = Income::with('Category')->get();
        info($incomes);
        return view('income.index', compact('incomes'));
    }

    /**
     * show create form
     */
    public function create() {
        return view('income.create');
    }

    /**
     * store data to income db
     * 
     * @param $request
     */
    public function store(IncomeRequest $request) {
        Income::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'created_at' => now()
        ]);
        return redirect()->route('income.index');
    }
 
    /**
     * show edit form
     */
    public function edit($id) {
        $income = Income::find($id);
        return view('income.edit', compact('income'));
    }

    /**
     * destroy income data
     * 
     * @param $id
     */
    public function destroy($id) {
        $income = Income::find($id);
        $income->delete();
        return redirect()->route('income.index');
    }
}
