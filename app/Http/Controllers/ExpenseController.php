<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{


    public function index(Request $request)
    {
        $qry = Expense::with('category', 'user');

        // search
        if ($request->ajax()) {

            $search = request()->input('search');

            $qry->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });

            $expenses = $qry->paginate(10);

            return response()->json(['expenses' => $expenses]);
        }
        $expenses = $qry->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {

        $categories = Category::pluck('title', 'id');
        // dd($categories);
        return view('expenses.create', compact('categories'));
    }

    public function store(StoreExpenseRequest $request)
    {

        $user_id = Auth::user()->id;

        $imageName = '';

        // get image file and save in public/images dir

        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/expenses/'), $imageName);
        }

        Expense::create([
            'name'  =>  $request->name,
            'user_id'   => $user_id,
            'date'  => $request->date,
            'category_id' => $request->category_id,
            'img' =>  $imageName != '' ? 'images/expenses/' . $imageName : '',
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        $categories = Category::pluck('title', 'id');
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {

        $user_id = Auth::user()->id;
        $date = Carbon::parse($request->date)->format('Y-m-d');

        $expense->update([
            'name'  =>  $request->name,
            'user_id'   => $user_id,
            'date'  => $date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);


        // if image is updated

        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/expenses/'), $imageName);
            $expense->update([
                'img' => 'images/expenses/' . $imageName,
            ]);
        }

        // when remove image in update
        if ($request->remove_image  && $expense->img) {

            $this->removeImage($expense->img);
            // update image value to null
            $expense->update([
                'img' => ""
            ]);
        }
        return redirect()->route('expenses.index');
    }

    // public function show()
    // {
    //     dd('show');
    // }

    public function destroy(Expense $expense)
    {
        $this->removeImage($expense->img);
        $expense->delete();
        return redirect()->route('expenses.index');
    }






    /**
     * delete old image
     *
     * @param @string $image
     */
    private function removeImage($image)
    {
        // dd('hi');
        $imagePath =  $image;
        // dd($imagePath);
        if (File::exists($imagePath)) {
            unlink(public_path($imagePath));
        }
    }
}
