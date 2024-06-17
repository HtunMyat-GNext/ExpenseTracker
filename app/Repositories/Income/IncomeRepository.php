<?php

namespace App\Repositories\Income;

use Illuminate\Support\Carbon;
use App\Models\Income;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class IncomeRepository implements IncomeRepositoryInterface
{
    /**
     * Get all income records.
     */
    public function getAll($request)
    {
        // get login user id
        $user_id = User::getCurrentUserId();
        $filter = $request->input('filter');
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $incomes = Income::with('Category')->where('user_id', $user_id);

        if ($filter == "all") {
            $incomes = $incomes->paginate(10);
        } else if (is_numeric($filter)) {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $filter)->paginate(10);
        } else {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $currentMonth)->paginate(10);
        }
        return $incomes;
    }

    /**
     * Show the form for creating a new income record.
     */
    public function create()
    {
        $user_id = User::getCurrentUserId();
        $categories = Category::where('user_id', $user_id)->get();
        return $categories;
    }

    /**
     * Show the form for editing the specified income record.
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id)
    {
        $user_id = User::getCurrentUserId();
        $income = Income::find($id);
        $categories = Category::where('user_id', $user_id)->get();
        return compact('income', 'categories');
    }

    /**
     * Store a new income record.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store($request)
    {
        $imageName = '';
        // if request have image param, move image to public folder path
        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        try {
            DB::beginTransaction();
            Income::create([
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $request->date,
                'image' => $imageName
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Update an existing income record by ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    public function update($request, $id)
    {
        $income = Income::findOrFail($id);
        // when request array have image key
        if ($request->has('image')) {
            // Delete the old image if it exists
            if ($income->image) {
                $this->removeImage($income->image);
            }
            // store new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $income->update([
                'image' => $imageName
            ]);
        }

        // when remove image in update
        if ($request->input('remove_image') && $income->image) {
            $this->removeImage($income->image);
            // update image value to null
            $income->update([
                'image' => ""
            ]);
        }

        try {
            DB::beginTransaction();
            $income->update([
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $request->date,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Delete an income record by ID.
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        // find income data
        $income = Income::findOrFail($id);
        if ($income->image) {
            // when delete the icome, it's image also disappear
            $this->removeImage($income->image);
        }
        $income->delete();
    }

    /**
     * Filter income records based on the specified filter criteria and search query.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $export
     * @return mixed
     */
    public function filterIncome($request, $export)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $query = $request->input('search');
        $filter = $request->input('filter');
        $user_id = User::getCurrentUserId();
        $incomes = Income::with('Category')->where('user_id', $user_id);
        if ($filter == 'default') {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $currentMonth)->where('title', 'LIKE', "%{$query}%");
        } else if (is_numeric($filter)) {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $filter)->where('title', 'LIKE', "%{$query}%");
        } else {
            $incomes = $incomes->where('title', 'LIKE', "%{$query}%");
        }
        if ($export) {
            return $incomes->get();
        }
        return $incomes->paginate(10);
    }

    /**
     * delete old image
     *
     * @param @string $image
     */
    private function removeImage($image)
    {
        $imagePath = 'images/' . $image;
        if (File::exists($imagePath)) {
            unlink(public_path($imagePath));
        }
    }
}
