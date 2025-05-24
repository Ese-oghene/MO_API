<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\Order\OrderService;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;


/**
 * @group Order Management
 * @groupDescription Handles operations related to orders, such as creation, retrieval, updating, and deletion.
 */
class OrderController extends Controller
{
     protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

     /**
     * List Orders
     *
     * Returns a list of all orders along with their items.
     */
    public function index(): JsonResponse
    {
        return $this->orderService->getAllWithItems()->toJson();
    }

    /**
     * Create Order
     *
     * Creates a new order in the system.
     */
    public function store(OrderRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->orderService->createOrder($data)->toJson();
    }

    /**
     * Show Order
     *
     * Returns details of a specific order by its ID.
     */
    public function show(int $id): JsonResponse
    {
        return $this->orderService->findOrderById($id)->toJson();
    }

    /**
     * Update Order
     *
     * Updates details of an existing order.
     */
    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        return $this->orderService->updateOrder($id, $data)->toJson();
    }

    /**
     * Delete Order
     *
     * Deletes an order by its ID.
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->orderService->deleteOrder($id)->toJson();
    }


    /**
     * Download PDF of User Orders
     *
     * Generates and returns a PDF of the specified user's orders.
     */
    public function downloadUserOrdersPdf(int $userId): JsonResponse
    {
        return $this->orderService->generateUserOrdersPdf($userId)->toJson();
    }

}
