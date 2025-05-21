<?php

namespace App\Services\OrderItem;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\OrderItem\OrderItemRepository;

class OrderItemServiceImplement extends ServiceApi implements OrderItemService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "";
     /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected OrderItemRepository $mainRepository;

    public function __construct(OrderItemRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
