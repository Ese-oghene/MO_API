<?php

namespace App\Services\OrderItem;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\OrderItem\OrderItemRepository;
use App\Http\Resources\OrderItemResource;

class OrderItemServiceImplement extends ServiceApi implements OrderItemService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "Order Item";
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
     protected OrderItemRepository $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
      $this->orderItemRepository = $orderItemRepository;
    }

    public function createItem(array $data): OrderItemService
    {
        try {
          $orderItem = $this->orderItemRepository->createItem($data);

            return $this->setCode(201)
                ->setMessage("Order Item Created Successfully")
                ->setData(new OrderItemResource($orderItem));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Order Item Creation Failed")
                ->setError($e->getMessage());
        }
    }

    public function updateItem(int $id, array $data): OrderItemService
    {
        try {
            $orderItem = $this->orderItemRepository->updateItem($id, $data);

                return $this->setCode(200)
                    ->setMessage("Order Item Updated Successfully")
                    ->setData(new OrderItemResource($orderItem));
        } catch (\Exception $e) {
        return $this->setCode(400)
                    ->setMessage("Order Item Update Failed")
                    ->setError($e->getMessage());
        }
    }

    public function deleteItem(int $id): OrderItemService
    {
        try {
           $deleted = $this->orderItemRepository->deleteItem($id);

            if (!$deleted) {
                return $this->setCode(404)
                    ->setMessage("Order Item Not Found or Already Deleted");
            }

            return $this->setCode(200)
                ->setMessage("Order Item Deleted Successfully");
        } catch (\Exception $e) {
             return $this->setCode(400)
                ->setMessage("Order Item Deletion Failed")
                ->setError($e->getMessage());
        }
    }

    public function findItemById(int $id): OrderItemService
    {
        try {
          $orderItem = $this->orderItemRepository->findItemById($id);

            if (!$orderItem) {
                return $this->setCode(404)->setMessage("Order Item Not Found");
            }

            return $this->setCode(200)
                ->setMessage("Order Item Details")
                ->setData(new OrderItemResource($orderItem));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Failed to fetch order item")
                ->setError($e->getMessage());
        }
    }

    public function getItemsByOrderId(int $orderId): OrderItemService
    {
        try {
            $items = $this->orderItemRepository->getItemsByOrderId($orderId);

            return $this->setCode(200)
                ->setMessage("Order Items for Order #{$orderId}")
                ->setData(OrderItemResource::collection($items));
        } catch (\Exception $e) {
             return $this->setCode(400)
                ->setMessage("Failed to fetch order items")
                ->setError($e->getMessage());
        }
    }

}
