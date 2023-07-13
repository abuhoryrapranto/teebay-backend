<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\OrderController;
use App\Http\Controllers\V1\VerifyEmailController;

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

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::group([

    'prefix' => 'v1'

], function () {

    Route::group([

        'prefix' => 'auth'

    ], function () {

        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::group([

        'middleware' => 'auth:sanctum'

    ], function () {

        Route::get('/product/categories', [ProductController::class, 'getAllCategories']);
        Route::put('/product/increment-views/{slug}', [ProductController::class, 'insertProductView']);
        Route::resource('product', ProductController::class);

        Route::group([

            'prefix' => 'order'
    
        ], function () {
    
            Route::post('/', [OrderController::class, 'orderProduct']);
            Route::get('/{type}', [OrderController::class, 'getOrderProducts']);
        });
    });

});


Route::get('/email-test', [OrderController::class, 'mailTest']);