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
        $expenses = Expense::with('category', 'user');
        $months = config('custom.months');
        $filter = $request->input('filter'); // filters
        $query = $request->input('search'); // search keyword
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        if ($request->ajax()) {
            if (!empty($query)) {
                $expenses = $this->filterExpense($expenses, $filter, $query, $export = false);
            } else {
                $expenses = $this->filterExpense($expenses, $filter, $query, $export = false);
            }
            return view('expenses.partial.search', compact('expenses'))->render();
        }

        if ($filter == "all") {
            $expenses = $expenses->paginate(10);
        } else if (is_numeric($filter)) {
            $expenses = $expenses->whereYear('date', $currentYear)->whereMonth('date', $filter)->paginate(10);
        } else {
            $expenses = $expenses->whereYear('date', $currentYear)->whereMonth('date', $currentMonth)->paginate(10);
        }

        return view('expenses.index', compact('expenses', 'months'));
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

    public function export($format, $filter = null, $query = null)
    {
        $current_year = date('Y');
        if ($filter == 'default') {
            $month = date('F');
        } else if ($filter == 'all') {
            $month = 'All';
        } else {
            $month = date('F', mktime(0, 0, 0, $filter, 1));
        }
        // file name with current date time
        $fileName = $current_year . '_' . $month . '_Expense.' . $format;
        // get expense data by login user id
        $user_id = auth()->user()->id;
        // get expense data
        $expenses = Expense::where('user_id', $user_id);
        $expenses = $this->filterExpense($expenses, $filter, $query, $export = true);
        // sum total amount to display in excel
        $total_amount = $expenses->sum('amount');
        if ($format == 'pdf') {
            // return pdf format view
            $pdf = LaravelMpdf::loadView('expenses.exports.pdf', compact('expenses', 'total_amount', 'month'));
            // download pdf with current date time name
            return $pdf->download($fileName);
        }
        $expenseExport = new ExpensesExport($expenses, $total_amount); // Pass $expenses and $total_amount to ExpenseExport
        return Excel::download($expenseExport, $fileName);
    }

    /**
     * Filters the expenses based on the specified filter criteria and search query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $expenses The income query builder.
     * @param string $filter The filter type ('current' for current month or 'all').
     * @param string $query The search query to filter expenses by title.
     * @param int $currentYear The current year to filter expenses.
     * @param int $currentMonth The current month to filter expenses if 'current' filter is applied.
     */
    private function filterExpense($expenses, $filter, $query, $export)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        if ($filter == 'default') {
            $expenses = $expenses->whereYear('date', $currentYear)->whereMonth('date', $currentMonth)->where('name', 'LIKE', "%{$query}%");
        } else if (is_numeric($filter)) {
            $expenses = $expenses->whereYear('date', $currentYear)->whereMonth('date', $filter)->where('name', 'LIKE', "%{$query}%");
        } else {
            $expenses = $expenses->where('name', 'LIKE', "%{$query}%");
        }
        if ($export) {
            return $expenses->get();
        }
        return $expenses->paginate(10);
    }
}
