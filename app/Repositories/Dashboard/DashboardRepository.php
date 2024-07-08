<?php

namespace App\Repositories\Dashboard;

use Illuminate\Support\Carbon;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Event;

class DashboardRepository implements DashboardRepositoryInterface
{
    /**
     * Retrieves all necessary data for the dashboard based on the request.
     * 
     * This method fetches the total income, total expenses, number of categories, number of events, and
     * categorized expenses for the current month or a specified date range. It applies date filters
     * to the queries based on the presence of start and end dates in the request.
     * 
     * @param Request $request
     * @return array
     */
    public function getAll($request)
    {
        $user_id = Auth::user()->id;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $income_query = Income::where('user_id', $user_id);
        $expense_query = Expense::where('user_id', $user_id);
        $category_query = Category::where('user_id', $user_id);
        $event_query = Event::where('user_id', $user_id);
        $expense_category_query = Expense::selectRaw('category_id, SUM(amount) as total, COUNT(*) as count')
            ->where('user_id', $user_id);
        // Apply date filters to queries based on the presence of start and end dates in the request
        // If both start and end dates are provided, filter by date range
        if (!empty($startDate) && !empty($endDate)) {
            $income_query->whereBetween('date', [$startDate, $endDate]);
            $expense_query->whereBetween('date', [$startDate, $endDate]);
            $category_query->whereBetween('created_at', [$startDate, $endDate]);
            $event_query->whereBetween('created_at', [$startDate, $endDate]);
            $expense_category_query->whereBetween('date', [$startDate, $endDate]);
            // If only start date is provided, filter from start date onwards
        } else if (!empty($startDate) && empty($endDate)) {
            $income_query->where('date', '>=', $startDate);
            $expense_query->where('date', '>=', $startDate);
            $category_query->where('created_at', '>=', $startDate);
            $event_query->where('created_at', '>=', $startDate);
            $expense_category_query->where('date', '>=', $startDate);
            // If only end date is provided, filter up to end date
        } else if (empty($startDate) && !empty($endDate)) {
            $income_query->where('date', '<=', $endDate);
            $expense_query->where('date', '<=', $endDate);
            $category_query->where('created_at', '<=', $endDate);
            $event_query->where('created_at', '<=', $endDate);
            $expense_category_query->where('date', '<=', $endDate);
            // If no dates are provided, filter by current month
        } else {
            $income_query->whereYear('date', $currentYear)->whereMonth('date', $currentMonth);
            $expense_query->whereYear('date', $currentYear)->whereMonth('date', $currentMonth);
            $category_query->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
            $event_query->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
            $expense_category_query->whereYear('date', $currentYear)->whereMonth('date', $currentMonth);
        }
        $incomes = $income_query->sum('amount');
        $expenses = $expense_query->sum('amount');
        $categories = $category_query->count();
        $events = $event_query->count();
        $categories_data = $this->getExpensesByCategory($expense_category_query);
        $data = compact('incomes', 'expenses', 'events', 'categories', 'categories_data');
        return $data;
    }

    /**
     * Retrieves expenses grouped by category with their total and count.
     * 
     * This method takes a query object as input, groups the expenses by category, 
     * calculates the total and count for each category, and returns an array of 
     * objects containing the category name, total, count, and color.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return array
     */
    private function getExpensesByCategory($query)
    {
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
