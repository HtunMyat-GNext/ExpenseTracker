<?php

namespace App\Repositories\Income;

interface IncomeRepositoryInterface
{
    /**
     * Get all income records.
     *
     * @return mixed
     */
    public function index($request);

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
    public function store(array $data);

    /**
     * Update an existing income record by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete an income record by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);
}
