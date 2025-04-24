<?php

namespace App\Services\V1\Interfaces\Tasks;

use App\Services\V1\Interfaces\ServiceInterface;

interface ITaskStatusService extends ServiceInterface {
    
    /**
     * Create a new task status.
     *
     * @param array $payload
     * @return array
     */
    public function create(array $payload): array;

    /**
     * Update an existing task status.
     *
     * @param int $id
     * @param array $payload
     * @return array
     */
    public function update(int $id, array $payload): array;

    /**
     * Delete an existing task status.
     *
     * @param int $id
     * @return array
     */
    public function delete(int $id): array;

}