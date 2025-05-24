<?php

namespace App\Services\Order;

use LaravelEasyRepository\BaseService;

interface OrderService extends BaseService{

     public function createOrder(array $data);

    public function updateOrder(int $id, array $data);

    public function deleteOrder(int $id);

    public function findOrderById(int $id);

    public function getAllWithItems();

    public function generateUserOrdersPdf(int $userId);
}
