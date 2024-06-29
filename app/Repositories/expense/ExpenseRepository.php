<?php

namespace App\Repositories\expense;

use App\Models\Expense;
use Illuminate\Support\Facades\File;
use App\Repositories\expense\ExpenseRepositoryInterface;

class ExpenseRepository implements ExpenseRepositoryInterface
{

    /**
     * handle
     *
     * @param @array $datas
     * @param @id $expense_id(only for update)
     */
    public function store(array $request, ?int $id = null): string
    {
        $imageName = '';

        if (isset($request['image'])) {
            $imageName = time() . '.' . $request['image']->extension();

            if ($id != null) {
                $expense = Expense::findOrFail($id);
                if ($expense->img) {
                    $this->removeImage($expense->img);
                }
            }

            $request['image']->move(public_path('images/expenses'), $imageName);
        }

        return $imageName != '' ? 'images/expenses/' . $imageName : '';
    }

    public function destroy(string $path): void
    {
        $this->removeImage($path);
    }

    /**
     * delete old image
     *
     * @param @string $image
     */
    private function removeImage($path)
    {
        if (File::exists($path)) {
            File::delete(public_path($path));
        }
    }
}
