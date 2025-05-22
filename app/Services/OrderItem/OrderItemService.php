<?php

namespace App\Services\OrderItem;

use LaravelEasyRepository\BaseService;

interface OrderItemService extends BaseService{

    public function createItem(array $data);

    public function updateItem(int $id, array $data);

    public function deleteItem(int $id);

    public function findItemById(int $id);

    public function getItemsByOrderId(int $orderId);

    
}
