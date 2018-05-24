<?php

namespace App\Http\Controllers;

use App\Operation;
use App\services\operation\CreationService;
use Illuminate\Http\Request;

/**
 * Контроллер операций.
 */
class OperationController extends Controller
{

    /**
     * Список всех операций.
     *
     * @return string
     */
    public function all()
    {
        return response()->json([
            'operations' => Operation::query()
                ->orderBy('action_at', 'asc')
                ->orderBy('created_at', 'asc')
                ->get(),
            '_links' => [
                'create' => url('/api/v1/operations'),
            ],
        ]);
    }

    /**
     * Добавление операции.
     *
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        $service = new CreationService($request);
        $operation = $service->create();

        return response()->json(
            [
                '_links' => [
//                    'confirm' => url(strtr('/api/v1/operations/{id}/confirm', ['{id}' => $operation->id])),
//                    'decline' => url(strtr('/api/v1/operations/{id}/decline', ['{id}' => $operation->id])),
                    'update' => url(strtr('/api/v1/operations/{id}', ['{id}' => $operation->id])),
                    'delete' => url(strtr('/api/v1/operations/{id}', ['{id}' => $operation->id])),
                ],
            ],
            201
        );
    }

    /**
     * Редактирование операции.
     *
     * @param $id
     * @return string
     */
    public function update($id)
    {
        return 'Update the operation will be here';
    }

    /**
     * Удаление операции.
     *
     * @param $id
     * @return string
     */
    public function delete($id)
    {
        return 'Soft delete the operation will be here';
    }

}