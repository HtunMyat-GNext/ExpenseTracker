<?php

namespace App\Repositories\expense;

use Illuminate\Http\Request;

interface ExpenseRepositoryInterface
{
    public function store(array $request, int $id): string;

    public function destroy(string $path): void;
}
