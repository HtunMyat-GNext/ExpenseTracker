<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Models\Income;
use Illuminate\Support\Facades\File;

class IncomeController extends Controller
{
    /**
     * show index page
     */
    public function index()
    {
        $incomes = Income::with('Category')->get();
        return view('income.index', compact('incomes'));
    }

    /**
     * show create form
     */
    public function create()
    {
        return view('income.create');
    }

    /**
     * store data to income db
     * 
     * @param $request
     */
    public function store(IncomeRequest $request)
    {
        $imageName = '';
        // if request have image param, move image to public folder path
        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        // save income data to database
        Income::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'image' => $imageName
        ]);
        // redirect to income list
        return redirect()->route('income.index');
    }

    /**
     * update income data
     * 
     * @param $request
     * @param $id
     */
    public function update(IncomeRequest $request, $id)
    {
        $income = Income::findOrFail($id);
        
        if ($request->has('image')) {
            $imageName = $income->image;
            // get image file from local 
            $oldImage = public_path('images/' . $imageName);
            // Delete the old image if it exists
            if ($oldImage && File::exists(public_path('images/' . $oldImage))) {
                File::delete(public_path('images/' . $oldImage));
            }

            // store new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $income->update([
                'image' => $imageName
            ]);
        }

        $income->update([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);
        return redirect()->route('income.index');
    }

    /**
     * show edit form
     * 
     * @param $id
     */
    public function edit($id)
    {
        $income = Income::find($id);
        return view('income.edit', compact('income'));
    }

    /**
     * destroy income data
     * 
     * @param $id
     */
    public function destroy($id)
    {
        $income = Income::find($id);
        $income->delete();
        return redirect()->route('income.index');
    }
}
