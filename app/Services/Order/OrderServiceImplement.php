<?php

namespace App\Services\Order;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Order\OrderRepository;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderServiceImplement extends ServiceApi implements OrderService{

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
     protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
      $this->orderRepository = $orderRepository;
    }

    public function createOrder(array $data): OrderService
    {
        try {

            // Inject authenticated user ID
             $data['user_id'] = Auth::id();
              $order = $this->orderRepository->createOrder($data);

            return $this->setCode(201)
                ->setMessage("Order Created Successfully")
                ->setData(new OrderResource($order));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Order Creation Failed")
                ->setError($e->getMessage());
        }

    }

    public function updateOrder(int $id, array $data): OrderService
    {
        try {

            // Log::info('Update order data', $data);

            $order = $this->orderRepository->updateOrder($id, $data);

            return $this->setCode(200)
                ->setMessage("Order Updated Successfully")
                ->setData(new OrderResource($order));

        } catch (\Exception $e) {
             return $this->setCode(400)
                ->setMessage("Order Update Failed")
                ->setError($e->getMessage());
        }
    }

    public function deleteOrder(int $id): OrderService
    {
        try {
           $deleted = $this->orderRepository->deleteOrder($id);

            if (!$deleted) {
                return $this->setCode(404)
                    ->setMessage("Order Not Found or Already Deleted");
            }

            return $this->setCode(200)
                ->setMessage("Order Deleted Successfully");
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Order Deletion Failed")
                ->setError($e->getMessage());
        }
    }

    public function findOrderById(int $id): OrderService
    {
        try {
           $order = $this->orderRepository->findOrderById($id);

            if (!$order) {
                return $this->setCode(404)->setMessage("Order Not Found");
            }

            return $this->setCode(200)
                ->setMessage("Order Details")
                ->setData(new OrderResource($order));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Failed to fetch order")
                ->setError($e->getMessage());
        }
    }

    public function  getAllWithItems(): OrderService
    {
        try {
            $orders = $this->orderRepository->getAllWithItems();

            return $this->setCode(200)
                ->setMessage("Order List")
                ->setData(OrderResource::collection($orders));
        } catch (\Exception $e) {
              return $this->setCode(400)
                ->setMessage("Failed to fetch orders")
                ->setError($e->getMessage());
        }
    }


    public function generateUserOrdersPdf(int $userId): OrderService
{
    try {
        $user = User::findOrFail($userId);
        $orders = $this->orderRepository->getOrdersByUserId($userId);

        $pdf = Pdf::loadView('pdf.user-orders', [
            'user' => $user,
            'orders' => $orders
        ]);

        $fileName = "user_orders_{$userId}.pdf";
        $path = "public/pdfs/{$fileName}";
        Storage::put($path, $pdf->output());

        // Generate full URL including scheme and host
        $pdfUrl = url(Storage::url("pdfs/{$fileName}"));
        // This produces something like: http://localhost:8000/storage/pdfs/user_orders_4.pdf

        return $this->setCode(200)
                    ->setMessage("PDF generated")
                    ->setData([
                        'url' => $pdfUrl
                    ]);

    } catch (\Exception $e) {
        return $this->setCode(400)
                    ->setMessage("Failed to generate PDF")
                    ->setError($e->getMessage());
    }
}


    // public function generateUserOrdersPdf(int $userId): OrderService
    // {
    //     try {
    //         $user = User::findOrFail($userId);
    //         $orders = $this->orderRepository->getOrdersByUserId($userId);

    //         $pdf = Pdf::loadView('pdf.user-orders', [
    //             'user' => $user,
    //             'orders' => $orders
    //         ]);

    //         $fileName = "user_orders_{$userId}.pdf";
    //         $path = "public/pdfs/{$fileName}";
    //         Storage::put($path, $pdf->output());

    //         return $this->setCode(200)
    //                     ->setMessage("PDF generated")
    //                     ->setData([
    //                         'url' => Storage::url("pdfs/{$fileName}")
    //                     ]);

    //     } catch (\Exception $e) {
    //         return $this->setCode(400)
    //                     ->setMessage("Failed to generate PDF")
    //                     ->setError($e->getMessage());
    //     }
    // }

}
