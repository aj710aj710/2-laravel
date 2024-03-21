<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//call back
Route::match(array('GET', 'POST'), 'verify', [OrderController::class, 'verify'])->name('payment.verify');
Route::get('/package', [PackageController::class, 'index']);


Route::get('/plans',[PlanController::class,'index']);
Route::post('/plans',[PlanController::class,'upload']);
Route::post('/subscriptions',[SubscriptionController::class,'uploadsubscriptions']);
Route::post('/subscribers',[SubscriptionController::class,'uploadsubscribers']);
