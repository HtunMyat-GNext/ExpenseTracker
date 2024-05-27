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
    public function index(Request $request)
    {
        $qry = Category::query();

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

    /**
     * data searching
     */
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $categories = DB::table('categories')->where('title', 'LIKE', '%' . $request->search . "%")->get();
            dd($categories);
            if ($categories) {
                $iteration = 1; // Manual iteration counter
                foreach ($categories as $category) {
                    $output .= '<tr>' .
                        '<td>' . $iteration . '</td>' .
                        '<td>' . $category->title . '</td>' .
                        '<td>' . $category->is_income . '</td>' .
                        '</tr>';
                    $iteration++; // Increment the counter
                }
                return response($output);
            }
        }
    }



    
}
