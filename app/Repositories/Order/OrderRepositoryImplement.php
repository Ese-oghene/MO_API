<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($data) {

            $orderItems = $data['order_items'] ?? [];
            unset($data['order_items']);

            $order = Order::create($data);

            foreach ($orderItems as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            return $order->load('orderItems');
        });

    }



        private function getProductPrice(int $productId): float
        {
            return \App\Models\Product::findOrFail($productId)->price;
        }


    public function updateOrder(int $id, array $data)
{
    $order = $this->model->findOrFail($id);

    // Update order status if provided, otherwise keep the current status
    $order->update([
        'status' => $data['status'] ?? $order->status,
    ]);

    // Handle order items if provided
    if (!empty($data['items'])) {

        // Delete old items
        $order->orderItems()->delete();

        $total = 0;

        // Recreate order items
        foreach ($data['items'] as $item) {
            $subtotal = $item['quantity'] * $this->getProductPrice($item['product_id']);
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $this->getProductPrice($item['product_id']),
            ]);

            $total += $subtotal;
        }

        // Update the order total
        $order->update(['total' => $total]);
    }

    return $order->load('orderItems');
}


    public function findOrderById(int $id)
    {
        return $this->model->with('orderItems')->findOrFail($id);
    }

    public function deleteOrder(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getAllWithItems()
    {
        return $this->model->with('orderItems')->get();
    }

    
    public function getOrdersByUserId(int $userId)
    {
        return $this->model
            ->with('orderItems.product.category')
            ->where('user_id', $userId)
            ->get();
    }


}
