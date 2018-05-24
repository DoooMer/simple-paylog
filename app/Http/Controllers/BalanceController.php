<?php

namespace App\Http\Controllers;

use App\services\BalanceService;

/**
 * Контроллер баланса.
 */
class BalanceController extends Controller
{
    /**
     * @var BalanceService
     */
    private $balanceService;

    /**
     * @param $balanceService
     */
    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Получение текущего баланса.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance()
    {
        return response()->json([
            'balance' => $this->balanceService->calculate(),
        ]);
    }
}