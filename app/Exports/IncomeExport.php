<?php

namespace App\Exports;

use App\Models\Income;

class IncomeExport
{
    public function collection()
    {
        return Income::all();
    }
}
