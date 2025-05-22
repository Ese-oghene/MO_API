<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\OrderItem\OrderItemService;
use App\Http\Requests\Order\OrderItemRequest;
use App\Http\Requests\Order\UpdateOrderItemRequest;

/**
 * @group Order Item Management
 * @groupDescription Handles operations related to order items such as listing, creation, update, and deletion.
 */
class OrderItemController extends Controller
{
   protected OrderItemService $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

     /**
     * List Order Items by Order ID
     *
     * Returns a list of order items for a specific order.
     */
    public function index(int $orderId): JsonResponse
    {
        return $this->orderItemService->getItemsByOrderId($orderId)->toJson();
    }

    /**
     * Show Order Item
     *
     * Returns details of a specific order item by its ID.
     */
    public function show(int $id): JsonResponse
    {
        return $this->orderItemService->findItemById($id)->toJson();
    }

     /**
     * Create Order Item
     *
     * Creates a new order item.
     */
    public function store(OrderItemRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->orderItemService->createItem($data)->toJson();
    }

     /**
     * Update Order Item
     *
     * Updates an existing order item.
     */
    public function update(UpdateOrderItemRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        return $this->orderItemService->updateItem($id, $data)->toJson();
    }

    /**
     * Delete Order Item
     *
     * Deletes a specific order item.
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->orderItemService->deleteItem($id)->toJson();
    }


}
