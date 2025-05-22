<?php

namespace App\Repositories\OrderItem;

use LaravelEasyRepository\Repository;

interface OrderItemRepository extends Repository{

     public function createItem(array $data);

    public function updateItem(int $id, array $data);

    public function deleteItem(int $id);

    public function findItemById(int $id);

    public function getItemsByOrderId(int $orderId);
}
