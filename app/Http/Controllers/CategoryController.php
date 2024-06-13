<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * show create form
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * store function & Validation
     * Store a newly created category in the database with validation.
     */
    public function store(Request $request)
    {
        dd($request->all());
        $validatedData = $request->validate([
            'title' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = \App\Models\Category::where('title', $value)
                        ->where('', $request->is_income)
                        ->exists();
                    if ($exists) {
                        $fail('This category with the same title and type already exist.');
                    }
                },
            ],
            'is_income' => 'required|boolean',
            'color' => 'required|string',
        ]);

        \App\Models\Category::create([
            'user_id' => Auth::user()->id,
            'title' => $validatedData['title'],
            'is_income' => $validatedData['is_income'],
            'color' => $validatedData['color'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    /**
     * Display the index page for categories.
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $qry = Category::where('user_id', $user_id);

        if ($request->ajax()) {
            $search = $request->input('search');
            if ($search) {
                $qry->where('title', 'like', '%' . $search . '%')
                    ->orWhere('is_income', 'like', '%' . $search . '%');
            }
            $categories = $qry->paginate(10);
            return response()->json(['categories' => $categories]);
        }

        $categories = $qry->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * delete category
     * 
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }

    /**
     * show edit form
     * 
     * @param $id
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    /** 
     * Update the specified category in the database.
     * @param $id
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string',
            'is_income' => [
                'required',
                'boolean',
                function ($attribute, $value, $fail) use ($request, $id) {

                    // Check for existing category
                    $exists = Category::where('title', $request->title)
                        ->where('is_income', $value)
                        ->where('id', '<>', $id)
                        ->exists();
                    if ($exists) {
                        $fail('This category with the same title and type already exists.Please create new category. ');
                    }
                },
            ],
            'color' => 'required',

        ]);

        $category = Category::findOrFail($id);

        // Update the category with the validated data
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
}
