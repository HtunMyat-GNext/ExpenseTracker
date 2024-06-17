<?php

namespace App\Repositories\Income;

use Illuminate\Http\Request;

interface IncomeRepositoryInterface
{
    /**
     * Get all income records.
     *
     * @return mixed
     */
    public function getAll($request);

    /**
     * Show the form for creating a new income record.
     */
    public function create();

    /**
     * Edit an income record by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id);

    /**
     * Store a new income record.
     *
     * @param array $data
     * @return mixed
     */
    public function store($request);

    /**
     * Update an existing income record by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($request, $id);

    /**
     * Delete an income record by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Filter income records based on the specified filter criteria and search query.
     */
    public function filterIncome($request, $export);
}
