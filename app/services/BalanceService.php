<?php

namespace App\services;

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
            ->where('status', true)
            ->orderBy('action_at', 'desc')
            ->select(DB::raw('SUM(amount) as balance'))
            ->value('balance');
    }
}