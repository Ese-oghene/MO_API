<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|165|9FbVFVbaYdL611CxGmFDUpP2rqKAHV4MQsaXg4zle07d09cb
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("register", [AuthController::class, "register"])->name("register");
Route::post("login", [AuthController::class, "login"])->name("login");
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// PUBLIC PRODUCT ROUTE (NO AUTH REQUIRED)
Route::get('/products/category/{name}', [ProductController::class, 'getByCategoryName']);
Route::get('/products/subcategory/{name}', [ProductController::class, 'getBySubCategoryName']);
Route::get('/products/public', [ProductController::class, 'publicIndex']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Not relevant routes
// Route::get('/products/category/{id}', [ProductController::class, 'getByCategory']);
// Route::get('/products/subcategory/{id}', [ProductController::class, 'getBySubCategory']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });

     // General User Logout
    Route::post("logout", [AuthController::class, "logout"]);

    // User Order Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('{id}', [OrderController::class, 'show']);
        Route::patch('{id}', [OrderController::class, 'update']);
        Route::delete('{id}', [OrderController::class, 'destroy']);
    });

    Route::prefix('orderItems')->group(function () {
        Route::get('/order/{orderId}', [OrderItemController::class, 'index']); // Get all items by order ID
        Route::get('{id}', [OrderItemController::class, 'show']);              // Get single item by item ID
        Route::post('/', [OrderItemController::class, 'store']);               // Create new item
        Route::patch('{id}', [OrderItemController::class, 'update']);            // Update item
        Route::delete('{id}', [OrderItemController::class, 'destroy']);
    });

    // Admin Logout
    Route::post("/admin/logout", [AuthController::class, "logout"]);


    // Admin Product Management (only admins should access these)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/index', [ProductController::class, 'index']);
        Route::post('/store', [ProductController::class, 'store']);
        Route::get('/show/{id}', [ProductController::class, 'show']);
        Route::patch('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/delete/{id}', [ProductController::class, 'destroy']);
         // Additional routes for filtering products

         Route::get('/products/category/{id}', [ProductController::class, 'getByCategory']);
         Route::get('/products/subcategory/{id}', [ProductController::class, 'getBySubCategory']);
    });

    // Admin Order Management
    Route::prefix('admin/orders')->middleware('role:admin')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('{id}', [OrderController::class, 'show']);
        Route::patch('{id}', [OrderController::class, 'update']);
        Route::delete('{id}', [OrderController::class, 'destroy']);
        Route::get('/pdf/{userId}', [OrderController::class, 'downloadUserOrdersPdf']);

    });


});








