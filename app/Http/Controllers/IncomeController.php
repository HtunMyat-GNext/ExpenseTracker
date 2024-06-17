<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomeExport;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use App\Repositories\Income\IncomeRepositoryInterface;

class IncomeController extends Controller
{

    protected $incomeRepository;

    /**
     * IncomeController constructor.
     * 
     * @param IncomeRepositoryInterface $incomeRepository
     */
    public function __construct(IncomeRepositoryInterface $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * Display a listing of the incomes.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($query)) {
                $incomes = $this->incomeRepository->filterIncome($request, $export = false);
            } else {
                $incomes = $this->incomeRepository->filterIncome($request, $export = false);
            }
            return view('income.partial.search', compact('incomes'))->render();
        }

        $months = config('custom.months');
        $incomes = $this->incomeRepository->getAll($request);
        return view('income.index', compact('incomes', 'months'));
    }

    /**
     * show create form
     */
    public function create()
    {
        $categories = $this->incomeRepository->create();
        return view('income.create', compact('categories'));
    }

    /**
     * store data to income db
     *
     * @param $request
     */
    public function store(IncomeRequest $request)
    {
        $this->incomeRepository->store($request);
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
        $this->incomeRepository->update($request, $id);
        return redirect()->route('income.index');
    }

    /**
     * show edit form
     *
     * @param $id
     */
    public function edit($id)
    {
        $data = $this->incomeRepository->edit($id);
        $income = $data['income'];
        $categories = $data['categories'];
        return view('income.edit', compact('income', 'categories'));
    }

    /**
     * destroy income data
     *
     * @param $id
     */
    public function destroy($id)
    {
        $this->incomeRepository->delete($id);
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
        $current_year = date('Y');
        if ($filter == 'default') {
            $month = date('F');
        } else if ($filter == 'all') {
            $month = 'All';
        } else {
            $month = date('F', mktime(0, 0, 0, $filter, 1));
        }
        // file name with current date time
        $fileName = $current_year . '_' . $month . '_Income.' . $format;
        $request = new Request();
        $request->merge(['filter' => $filter, 'search' => $query]);
        $incomes = $this->incomeRepository->filterIncome($request, $export = true);
        // sum total amount to display in excel
        $total_amount = $incomes->sum('amount');
        if ($format == 'pdf') {
            // return pdf format view
            $pdf = LaravelMpdf::loadView('income.exports.pdf', compact('incomes', 'total_amount', 'month'));
            // download pdf with current date time name
            return $pdf->download($fileName);
        }
        $incomeExport = new IncomeExport($incomes, $total_amount); // Pass $incomes and $total_amount to IncomeExport
        return Excel::download($incomeExport, $fileName);
    }
}
