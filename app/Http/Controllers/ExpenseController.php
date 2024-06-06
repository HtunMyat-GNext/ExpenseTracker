<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ExpensesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class ExpenseController extends Controller
{


    public function index(Request $request)
    {
        $qry = Expense::with('category', 'user');

        if ($request->ajax()) {
            $search = $request->input('search');

            if ($search) {
                $qry->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('amount', 'like', '%' . $search . '%');
                });

                $expenses = $qry->get();

                return response()->json(['expenses' => $expenses]);
            } else {
                $expenses = $qry->paginate(5);
                return response()->json(['expenses' => $expenses]);
            }
        }

        $expenses = $qry->paginate(5);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = Category::where([['user_id', Auth::id()], ['is_income', 0]])->pluck('title', 'id');

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
        $categories = Category::where([['user_id', Auth::id()], ['is_income', 0]])->pluck('title', 'id');

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


    /**
     * Export income data in specified format.
     *
     * @param string $format The format to export the data ('pdf' or 'excel').
     * @return \Illuminate\Http\Response
     */
    // public function excelExport($format)
    // {
    //     // get current date time to add in file name
    //     $currentDateTime = now()->format('Y-m-d_H-i-s');
    //     // file name with current date time
    //     $fileName = $currentDateTime . '_income.' . $format;
    //     if ($format == 'pdf') {
    //         // get income data by loign user id
    //         $user_id = auth()->user()->id;
    //         // get income data
    //         $incomes = Expense::where('user_id', $user_id)->get();
    //         // sum total amount to display in excel
    //         $total_amount = $incomes->sum('amount');
    //         // return pdf format view
    //         $pdf = LaravelMpdf::loadView('income.exports.pdf', compact('incomes', 'total_amount'));
    //         // download pdf with current date time name
    //         return $pdf->download($fileName);
    //     }
    //     return Excel::download(new IncomeExport, $fileName);
    // }

    public function pdfExport(Request $request)
    {

        $dateRange = $request->date;

        // destruct to start and end date
        [$startDate, $endDate] = explode(' to ', $dateRange);


        // get current date time to add in file name
        $currentDateTime = now()->format('d-m-Y');

        // file name with current date time
        $fileName = $currentDateTime . '_expense.' . 'pdf';

        // get income data by loign user id
        $user_id = auth()->user()->id;

        // get expense data
        if ($request->has('date')) {
            $expenses = Expense::where('user_id', $user_id)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();
        }
        $expenses = Expense::where('user_id', $user_id)->get();



        // Sum total amount to display in excel
        $total_amount = $expenses->sum('amount');

        // Return the PDF export with the data
        return Excel::download(new ExpensesExport($startDate, $endDate, $expenses, $total_amount), $fileName);
    }
}
