<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Order;

class OrderRepositoryImplement extends Eloquent implements OrderRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected Order $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function createOrder(array $data)
    {
        return $this->model->create($data);
    }

    public function updateOrder(int $id, array $data)
    {
        $order = $this->model->findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function findOrderById(int $id)
    {
        return $this->model->with('items')->findOrFail($id);
    }

    public function deleteOrder(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getAllWithItems()
    {
        return $this->model->with('items')->get();
    }
    
}
