<?php

use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\BeneficiaryController;
use App\Http\Controllers\Affiliate\DashboardController;
use App\Http\Controllers\Affiliate\ProfileController;
use App\Http\Controllers\Affiliate\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('link', [AffiliateController::class, 'link'])->name('link');
Route::get('history', [AffiliateController::class, 'history'])->name('history');
Route::get('wallet', [AffiliateController::class, 'wallet'])->name('wallet');
Route::get('withdraw', [WithdrawalController::class, 'index'])->name('withdraw.index');
Route::post('withdraw/request', [WithdrawalController::class, 'withdrawalRequest'])->name('withdraw.request');
Route::post('beneficiary/store', [BeneficiaryController::class, 'store'])->name('beneficiary.store');
Route::post('beneficiary/update/{id}', [BeneficiaryController::class, 'update'])->name('beneficiary.update');
Route::get('beneficiary/info/{id}', [BeneficiaryController::class, 'edit'])->name('beneficiary.edit');
Route::post('beneficiary/delete/{id}', [BeneficiaryController::class, 'delete'])->name('beneficiary.delete');

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'myProfile'])->name('index');
    Route::post('profile-update', [ProfileController::class, 'profileUpdate'])->name('profile-update');
});
