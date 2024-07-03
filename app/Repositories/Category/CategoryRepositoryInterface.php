<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories.
     */
    public function getAll($request);
    /**
     * for create a new category .
     */
    public function create($request);
    /**
     * Edit category by ID.
     * @param int $id
     */
    public function edit($id);
    /**
     * Update an existing category by ID.
     * @param array $data
     * @param int $id
     */
    public function update(array $data, $id);
    /**
     * Store category by ID
     * @param array $data
     */
    public function store($data);
    /**
     * Delete category by ID
     * @param int $id
     */
    public function delete($category);
}
