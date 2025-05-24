<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Repository;

interface OrderRepository extends Repository{

    public function createOrder(array $data);

    public function updateOrder(int $id, array $data);

    public function findOrderById(int $id);

    public function deleteOrder(int $id);

    public function getAllWithItems();
    //get orders by user ID
    public function getOrdersByUserId(int $userId);
}
