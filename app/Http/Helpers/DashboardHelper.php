<?php

namespace App\HTTP\Helpers;

use App\Models\Expense;

class DashboardHelper
{
    public static function getExpensesByCategory($userId, $year, $month, $startDate = null, $endDate = null)
    {
        $query = Expense::selectRaw('category_id, SUM(amount) as total, COUNT(*) as count')
            ->where('user_id', $userId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        // Apply date range filters
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
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
