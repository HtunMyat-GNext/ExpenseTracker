<?php

namespace App\Http\Controllers;

enum CategoryType: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';
    case OTHERS = 'others';
}
