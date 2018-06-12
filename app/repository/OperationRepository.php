<?php

namespace App\repository;

use App\Operation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Репозиторий операций.
 */
class OperationRepository
{
    /**
     * @param int $pageSize
     * @return LengthAwarePaginator
     */
    public function getAllByPage(int $pageSize = 8): LengthAwarePaginator
    {
        return Operation::query()
            ->orderBy('action_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);
    }
}