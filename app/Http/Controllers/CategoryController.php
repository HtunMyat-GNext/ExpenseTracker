<?php

namespace App\Http\Controllers;

use App\Enums\CategoryType;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * show create form
     */
    public function create()
    {
        $types = CategoryType::cases();
        return view('categories.create', compact('types'));
    }

    /**
     * store function & Validation
     * Store a newly created category in the database with validation.
     */
    public function store(StoreCategoryRequest $request)
    {
        info($request);
        $this->categoryRepository->store($request);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    /**
     * Display the index page for categories.
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->getAll($request);
        if ($request->ajax()) {
            return response()->json(['categories' => $categories]);
        }
        return view('categories.index', compact('categories'));
    }

    /**
     * delete category
     * 
     */
    public function destroy(Category $category)
    {
        $this->categoryRepository->delete($category);
        return redirect()->route('categories.index');
    }

    /**
     * show edit form
     * 
     * @param $id
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->edit($id);
        return view('categories.edit', compact('category'));
    }

    /** 
     * Update the specified category in the database.
     * @param $id
     */
    public function update(UpdateCategoryRequest $request, $id)
    {

        $this->categoryRepository->update($request->all(), $id);
        return redirect()->route('categories.index');
    }
}
