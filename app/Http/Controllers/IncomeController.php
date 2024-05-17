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
        // find income data
        $income = Income::findOrFail($id);
        $income->delete();
        // when delete the icome, it's image also disappear
        $this->removeImage($income->image);
        return redirect()->route('income.index');
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
