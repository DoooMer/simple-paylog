<?php

namespace App\services\operation;

use App\Operation;
use Illuminate\Http\Request;

class CreationService
{
    /**
     * @var Operation
     */
    private $model;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->model = new Operation();//::create($request->all());
        $this->model->fill($request->only(['amount', 'action_at', 'description']));
        $this->model->user_id = $request->user()->id;
        $this->model->status = Operation::STATUS_NEW;
    }

    /**
     * @return bool
     * @throws \Throwable
     */
    public function create(): Operation
    {
        if ($this->model->saveOrFail()) {
            return $this->model;
        }

        return false;
    }
}