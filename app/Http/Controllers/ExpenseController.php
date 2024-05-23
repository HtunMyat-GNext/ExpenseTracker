<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{


    public function index()
    {
        $qry = Expense::query();

        if (request()->has('search')) {
            $search = request()->input('search');
            $qry->where(function ($query) use ($search) {
                // dd($query);
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });
        }

        $expenses = $qry->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(StoreExpenseRequest $request)
    {
        $user_id = Auth::user()->id;

        // get image file and save in public/images dir
        $imageName = '';

        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        Expense::create([
            'name'  =>  $request->name,
            'user_id'   => $user_id,
            'date'  => $request->date,
            // 'category_id' => 1,
            'img' =>  $imageName != '' ? 'images/' . $imageName : '',
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        // dd($request->all());
        // dd($request->remove_image);
        $expense->update($request->except('image'));


        // if image is updated
        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $expense->update([
                'img' => 'images/' . $imageName,
            ]);
        }

        // when remove image in update
        if ($request->remove_image  && $expense->img) {
            // dd('here');
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
        $expense->delete();
        return redirect()->route('expenses.index');
    }


    // live search
    // public function search(Request $request)
    // {
    //     // dd($request->all());
    //     if ($request->ajax()) {
    //         $output = "";
    //         $expenses = DB::table('expenses')->where('name', 'LIKE', '%' . $request->search . "%")->get();
    //         if ($expenses) {
    //             foreach ($expenses as $key => $expense) {
    //                 $output .= '<tr>' .
    //                     '<td>' . $expense->id . '</td>' .
    //                     '<td>' . $expense->title . '</td>' .
    //                     '<td>' . $expense->description . '</td>' .
    //                     '<td>' . $expense->price . '</td>' .
    //                     '</tr>';
    //             }
    //             return Response($output);
    //         }
    //     }
    // }
    /**
     * delete old image
     *
     * @param @string $image
     */
    private function removeImage($image)
    {
        // dd('hi');
        $imagePath = 'images/' . $image;
        if (File::exists($imagePath)) {
            unlink(public_path($imagePath));
        }
    }
}
