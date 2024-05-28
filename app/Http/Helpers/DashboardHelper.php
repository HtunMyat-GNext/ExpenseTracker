<?php

namespace App\HTTP\Helpers;

use App\Models\Expense;

class DashboardHelper
{
    public static function getExpensesByCategory($userId, $year, $month)
    {
        $datas = Expense::selectRaw('category_id, SUM(amount) as total, COUNT(*) as count')
            ->where('user_id', $userId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $data_ary = $datas->map(function ($item) {
            return [
                'name' => $item->category->title,
                'total' => $item->total,
                'count' => $item->count,
            ];
        });

        return $data_ary;
    }
}
