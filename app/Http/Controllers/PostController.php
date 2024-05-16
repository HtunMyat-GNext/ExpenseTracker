<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(){
        return view('categories.create');
    }

    public function master(){
        return view('categories.master');
    }

    public function delete($id) {
        info($id);
        return redirect()->route('categories.delete');
    }

}