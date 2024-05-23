<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Dotenv\Parser\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     */
    public function store(Request $request)
    {

        
        $validatedData = $request->validate([
            'title' => 'required',
            'is_income' => 'required',
            'color' => 'required',
        ]);


        $category = Category::query();
        $category->create([
            'user_id' => Auth::user()->id,
            'title'     => $validatedData['title'],
            'is_income' => $validatedData['is_income'],
            'color' => $validatedData ['color'],
        ]);


        return redirect()->route('categories.index');
    }

    /**
     * show index page
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * delete category
     * 
     */
    public function destroy(Category $category)
    {
        // dd('delete');
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
        return view('categories.edit',compact('category'));
    }

    
    /**
     * update form
     * 
     * @param $id
     */

     public function update(Request $request, $id )   
     {
        

       $category = Category::findOrFail($id);
      
       $category->update($request->only('title', 'is_income','color'));

       return redirect()->route('categories.index')->with('success', 'Category updated successfully.');

       


    }
}
