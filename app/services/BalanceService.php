<?php

namespace App\services;

use App\Operation;
use Illuminate\Support\Facades\DB;

/**
 * Сервис получения баланса.
 */
class BalanceService
{
    /**
     *
     *
     * @return float
     */
    public function calculate(): float
    {
        return (float) DB::table('operation')
            ->where('status', Operation::STATUS_CONFIRMED)
            ->orderBy('action_at', 'desc')
            ->select(DB::raw('SUM(amount) as balance'))
            ->value('balance');
    }
}