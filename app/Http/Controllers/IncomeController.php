<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Models\Category;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomeExport;

class IncomeController extends Controller
{
    /**
     * show index page
     */
    public function index(Request $request)
    {
        // get login user id 
        $user_id = Auth::user()->id;
        $query = $request->input('search');
        // check the http request with search query 
        if ($request->ajax()) {
            if (!empty($query)) {
                $incomes = Income::where('user_id', $user_id)->where('title', 'LIKE', "%{$query}%")->paginate(10);
            } else {
                $incomes = Income::where('user_id', $user_id)->paginate(10);
            }
            return view('income.partial.search', compact('incomes'))->render();
        }
        $incomes = Income::with('Category')->where('user_id', $user_id)->paginate(10);
        return view('income.index', compact('incomes'));
    }

    /**
     * show create form
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $categories = Category::where('user_id', $user_id)->get();
        return view('income.create', compact('categories'));
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
        $user_id = auth()->user()->id;
        $categories = Category::where('user_id', $user_id)->get();
        return view('income.edit', compact('income', 'categories'));
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
        if ($income->image) {
            // when delete the icome, it's image also disappear
            $this->removeImage($income->image);
        }
        $income->delete();
        return redirect()->route('income.index');
    }

    /**
     * Export income data in specified format.
     * 
     * @param string $format The format to export the data ('pdf' or 'excel').
     * @return \Illuminate\Http\Response
     */
    public function export($format)
    {
        return Excel::download(new IncomeExport, 'income.' . $format);
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
