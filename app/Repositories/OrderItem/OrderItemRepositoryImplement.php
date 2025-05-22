<?php

namespace App\Repositories\OrderItem;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\OrderItem;

class OrderItemRepositoryImplement extends Eloquent implements OrderItemRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected OrderItem $model;

    public function __construct(OrderItem $model)
    {
        $this->model = $model;
    }

     public function createItem(array $data)
    {
        return $this->model->create($data);
    }

    public function updateItem(int $id, array $data)
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function deleteItem(int $id)
    {
        return $this->model->destroy($id);
    }

    public function findItemById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function getItemsByOrderId(int $orderId)
    {
        return $this->model->where('order_id', $orderId)->get();
    }
}
