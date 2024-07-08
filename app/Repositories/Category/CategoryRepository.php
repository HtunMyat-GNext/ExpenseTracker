<?php

namespace App\Repositories\Category;

use App\Enums\CategoryType;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getAll($request)
    {
        $user_id = auth()->user()->id;
        $qry = Category::where('user_id', $user_id);

        if ($request->ajax()) {
            $search = $request->input('search');
            if ($search) {
                $qry->where('title', 'like', '%' . $search . '%');
            }
            $categories = $qry->paginate(10);
            return $categories;
        }
        if (!empty($request->filter)) {
            $qry = $this->filterCategory($qry, $request->filter);
        }
        $categories = $qry->paginate(10);
        return $categories;
    }

    public function create($request)
    {
        return Category::create($request);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return $category;
    }

    /**
     * Store Function
     */

    public function store($data)
    {

        Category::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'type' => CategoryType::from($data['type'])->value,
            'color' => $data['color'],
        ]);
    }

    public function update(array $data, $id)
    {
        // dd('hello');
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    /**
     * Delete category by ID.
     * @param int $id
     * @return boolean
     */
    public function delete($category)
    {
        $category->delete();
        return;
    }

    private function filterCategory($qry, $filter)
    {
        if ($filter == 'income') {
            $qry = $qry->where('type', CategoryType::INCOME);
        } else if ($filter == 'expense') {
            $qry = $qry->where('type', CategoryType::EXPENSE);
        } else if ($filter == "others") {
            $qry = $qry->where('type', CategoryType::OTHERS);
        } else {
            $qry = $qry;
        }
        return $qry;
    }
}
