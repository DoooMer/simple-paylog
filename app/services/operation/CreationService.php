<?php

namespace App\services\operation;

use App\Operation;
use Illuminate\Http\Request;

/**
 * Сервис добавления операций.
 */
class CreationService
{
    /**
     * @param Request $request
     * @return Operation|null
     * @throws \Throwable
     */
    public function create(Request $request): ?Operation
    {
        $model = new Operation();
        $model->fill($request->only(['amount', 'action_at', 'description']));
        $model->user_id = $request->user()->id;
        $model->status = Operation::STATUS_CONFIRMED;

        if ($model->saveOrFail()) {
            return $model;
        }

        return null;
    }
}