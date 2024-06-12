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
use Hamcrest\Type\IsNumeric;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Illuminate\Support\Carbon;

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
        $filter = $request->input('filter');
        // Total income for the current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $incomes = Income::with('Category')->where('user_id', $user_id);
        $months = config('custom.months');
        // check the http request with search query 
        if ($request->ajax()) {
            if (!empty($query)) {
                $incomes = $this->filterIncome($incomes, $filter, $query, $export = false);
            } else {
                $incomes = $this->filterIncome($incomes, $filter, $query, $export = false);
            }
            return view('income.partial.search', compact('incomes'))->render();
        }

        if ($filter == "all") {
            $incomes = $incomes->paginate(10);
        } else if (is_numeric($filter)) {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $filter)->paginate(10);
        } else {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $currentMonth)->paginate(10);
        }
        return view('income.index', compact('incomes', 'months'));
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
     * Export income data in the specified format.
     * 
     * @param {string} $format The format to export the data ('pdf' or 'excel').
     * @param {string|null} $filter The filter type ('current' for current month or 'all').
     * @param {string|null} $query The search query to filter incomes by title.
     * @return \Illuminate\Http\Response
     */
    public function export($format, $filter = null, $query = null)
    {
        // get current date time to add in file name
        $currentDateTime = now()->format('Y-m-d_H-i-s');
        // file name with current date time
        $fileName = $currentDateTime . '_income.' . $format;
        // get income data by login user id
        $user_id = auth()->user()->id;
        // get income data
        $incomes = Income::where('user_id', $user_id);
        $incomes = $this->filterIncome($incomes, $filter, $query, $export = true);
        // sum total amount to display in excel
        $total_amount = $incomes->sum('amount');
        if ($format == 'pdf') {
            // return pdf format view
            $pdf = LaravelMpdf::loadView('income.exports.pdf', compact('incomes', 'total_amount'));
            // download pdf with current date time name
            return $pdf->download($fileName);
        }
        $incomeExport = new IncomeExport($incomes, $total_amount); // Pass $incomes and $total_amount to IncomeExport
        return Excel::download($incomeExport, $fileName);
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

    /**
     * Filters the incomes based on the specified filter criteria and search query.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $incomes The income query builder.
     * @param string $filter The filter type ('current' for current month or 'all').
     * @param string $query The search query to filter incomes by title.
     * @param int $currentYear The current year to filter incomes.
     * @param int $currentMonth The current month to filter incomes if 'current' filter is applied.
     */
    private function filterIncome($incomes, $filter, $query, $export)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        if ($filter == 'default') {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $currentMonth)->where('title', 'LIKE', "%{$query}%");
        } else if (is_numeric($filter)) {
            $incomes = $incomes->whereYear('date', $currentYear)->whereMonth('date', $filter)->where('title', 'LIKE', "%{$query}%");
        } else {
            $incomes = $incomes->where('title', 'LIKE', "%{$query}%");
        }
        if ($export) {
            return $incomes->get();
        }
        return $incomes->paginate(10);
    }
}
