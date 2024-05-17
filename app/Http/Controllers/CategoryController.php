<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * show index page
     */
    public function index()
    {
        return view('categories.index');
    }

    /**
     * delete category
     * 
     * @param $id
     */
    public function delete($id)
    {
        return redirect()->route('categories.delete');
    }
}
