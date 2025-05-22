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
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');

// PUBLIC PRODUCT ROUTE (NO AUTH REQUIRED)
Route::get('/products/category/{name}', [ProductController::class, 'getByCategoryName']);
Route::get('/products/subcategory/{name}', [ProductController::class, 'getBySubCategoryName']);
Route::get('/products/public', [ProductController::class, 'publicIndex'])->name('products.public');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

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
    Route::post("logout", [AuthController::class, "logout"])->name("logout");

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
    Route::post("/admin/logout", [AuthController::class, "logout"])->name("admin.logout");


    // Admin Product Management (only admins should access these)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('admin.index');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('admin.show');
        Route::patch('/update/{id}', [ProductController::class, 'update'])->name('admin.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.destroy');
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
    });
    

});





//  user: any = null;

//   constructor(private http: HttpClient) {}

//   ngOnInit(): void {
//     const url = new URL(window.location.href);
//     const tokenFromUrl = url.searchParams.get('token');

//     if (tokenFromUrl) {
//       localStorage.setItem('auth_token', tokenFromUrl);
//       console.log('Token set from query param');

//       window.history.replaceState({}, '', window.location.pathname);
//     }
//     this.http.get<{ user: any }>('http://127.0.0.1:8000/api/me').subscribe({

//       next: (res) => {
//         this.user = res.user;
//         // this.user = res;
//         console.log('Fetched user:', this.user);
//       },
//       error: (err) => {
//         console.error('Failed to fetch user', err);
//       }
//     });

//   }

// {
//     "name":"Kilishi",
//     "description": "Bread is good for the body",
//     "price": "100.99",
//     "stock": 3,
//     "category_name":"hot sale",
//     "sub_category_name":"flash sale",
//     "raw_material":"flour"
// }


