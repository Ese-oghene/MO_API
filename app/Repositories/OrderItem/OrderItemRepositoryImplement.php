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

    // Write something awesome :)
}
