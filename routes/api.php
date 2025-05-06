<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
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



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });

     // General User Logout
    Route::post("logout", [AuthController::class, "logout"])->name("logout");

    // Admin Logout
    Route::post("/admin/logout", [AuthController::class, "logout"])->name("admin.logout");

    // Admin Product Management (only admins should access these)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('admin.index');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('admin.show');
        Route::patch('/update/{id}', [ProductController::class, 'update'])->name('admin.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.destroy');
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




