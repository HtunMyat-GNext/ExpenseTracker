<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Dashboard\DashboardRepositoryInterface;

class DashboardController
{
    protected $dashboardRepository;
    /**
     * DashboardController constructor.
     * 
     * @param DashbaordRepositoryInterface $dashboardRepository
     */
    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * Display the dashboard view with all necessary data.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->dashboardRepository->getAll($request);
        $incomes = $data['incomes'];
        $expenses = $data['expenses'];
        $categories = $data['categories'];
        $categories_data = $data['categories_data'];
        $events = $data['events'];
        return view('dashboard', compact('incomes', 'expenses', 'categories', 'categories_data', 'events'));
    }
}
