<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Helpers\DashboardHelper;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    public function index(Request $request)
    {
        // get current login user id
        $user_id = Auth::user()->id;
        // If request have date filter with start and end date
        // Total income for the current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $incomes = Income::where('user_id', $user_id)->whereYear('date', $currentYear)->whereMonth('date', $currentMonth)->sum('amount');
        $expenses = Expense::where('user_id', $user_id)->whereYear('date', $currentYear)->whereMonth('created_at', $currentMonth)->sum('amount');
        $categories = Category::count();

        // get data for pie-chart
        $categories_data = $this->getExpensesByCategory($user_id, $currentYear, $currentMonth);

        if ($request->start_date && $request->end_date) {
            // dd($request->all());
            // Get income for a specific date range if start and end dates are provided
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $incomes = Income::whereBetween('date', [$startDate, $endDate])->where('user_id', $user_id)->sum('amount');
            $expenses = Expense::whereBetween('date', [$startDate, $endDate])->where('user_id', $user_id)->sum('amount');
            $categories_data = $this->getExpensesByCategory($user_id, $currentYear, $currentMonth, $startDate, $endDate);
        }

        return view('dashboard', compact('incomes', 'expenses', 'categories', 'categories_data'));
    }

    private function getExpensesByCategory($userId, $year, $month, $startDate = null, $endDate = null)
    {
        $query = Expense::selectRaw('category_id, SUM(amount) as total, COUNT(*) as count')
            ->where('user_id', $userId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month);

        // Apply date range filters
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $datas = $query->groupBy('category_id')
            ->with('category')
            ->get();

        $data_ary = $datas->map(function ($item) {
            return [
                'name' => $item->category->title,
                'total' => $item->total,
                'count' => $item->count,
                'color' => $item->category->color,
            ];
        });

        return $data_ary;
    }
}
