<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ExpensesExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Budget;
use App\Models\Income;
use App\Models\User;
use App\Repositories\expense\ExpenseRepositoryInterface;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use App\Events\SetBudget;
// use App\Models\Event;

class ExpenseController extends Controller
{
    public $expenseRepo;

    public function __construct(ExpenseRepositoryInterface $expenseRepo)
    {
        $this->expenseRepo = $expenseRepo;
    }

    public function index(Request $request)
    {
        $user_id = auth()->id();
        $expenses = Expense::with('category', 'user')->where('user_id', $user_id);
        $months = config('custom.months');
        $filter = $request->input('filter'); // filters
        $query = $request->input('search'); // search keyword
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $budgets = Budget::where('user_id', $user_id)->first();
        $budgets_amount = $budgets ? $budgets->amount : 0;
        $total_income = Income::where('user_id', $user_id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');
        if ($request->ajax()) {
            event(new SetBudget('10000'));
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
        return view('expenses.index', compact('expenses', 'months', 'budgets_amount', 'total_income'));
    }

    public function create()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $user_id = User::getCurrentUserId();
        $budgets = Budget::where('user_id', $user_id)->sum('amount');
        $total_expense = Expense::where('user_id', $user_id)->whereMonth('date', $currentMonth)->whereYear('date', $currentYear)->sum('amount');
        $available_expense = $budgets - $total_expense;
        $categories = Category::where([['user_id', Auth::id()]])->pluck('title', 'id');

        return view('expenses.create', compact('categories', 'available_expense'));
    }

    public function store(StoreExpenseRequest $request)
    {

        $user_id = Auth::id();

        $imageName = $this->expenseRepo->store($request->all(), null);

        Expense::create([
            'name'  =>  $request->name,
            'user_id'   => $user_id,
            'date'  => $request->date,
            'category_id' => $request->category_id,
            'img' => $imageName,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        $categories = Category::where('user_id', Auth::user()->id)->pluck('title', 'id');

        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {

        $user_id = Auth::user()->id;
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $id = $expense->id;
        $imageName = $this->expenseRepo->store($request->all(), $id);
        // dd($imageName);
        $expense->update([
            'name'  =>  $request->name,
            'user_id'   => $user_id,
            'date'  => $date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'img' => $imageName ?? '',
            'description' => $request->description,
        ]);

        return redirect()->route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $this->expenseRepo->destroy($expense->img);
        $expense->delete();
        return redirect()->route('expenses.index');
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
