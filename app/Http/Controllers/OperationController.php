<?php

namespace App\Http\Controllers;

use App\Operation;
use App\services\operation\CreationService;
use App\UserRole;
use Illuminate\Http\Request;

/**
 * Контроллер операций.
 */
class OperationController extends Controller
{

    use CheckAccess;

    /**
     * Список всех операций.
     *
     * @return string
     */
    public function all()
    {
        $links = [];

        if ($this->can(UserRole::ADMIN)) {
            $links['create'] = url('/api/v1/operations');
        }

        return response()->json([
            'operations' => Operation::query()
                ->orderBy('action_at', 'asc')
                ->orderBy('created_at', 'asc')
                ->get(),
            '_links' => $links,
        ]);
    }

    /**
     * Добавление операции.
     *
     * @param Request $request
     * @param CreationService $service
     * @return string
     * @throws \ErrorException
     * @throws \Throwable
     */
    public function create(Request $request, CreationService $service)
    {
        $this->check(UserRole::ADMIN);

        $operation = $service->create($request);

        if ($operation === null) {
            throw new \ErrorException('Unable to add a new operation');
        }

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
        $this->check(UserRole::ADMIN);

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
        $this->check(UserRole::ADMIN);

        return 'Soft delete the operation will be here';
    }

}