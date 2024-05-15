<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index() {
        return view('income.index');
    }

    public function create() {
        return view('income.create');
    }

    public function edit() {
        return view('income.edit');
    }

    public function destroy($id) {
        info($id);
        return redirect()->route('income.index');
    }
}
