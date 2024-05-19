<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getTotalIncome(Request $request) {
        return redirect()->route('dashboard');
    }
}
