<?php

namespace App\Repositories\expense;

use App\Repositories\expense\ExpenseRepositoryInterface;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store()
    {
        dd('store');
    }
}
