<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use Illuminate\Support\Facades\Route;

/** Vendor Routes */
Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard'); // vendor.dashboard
Route::get('/profile', [VendorProfileController::class, 'index'])->name('profile'); // vendor.profile
Route::put('/profile', [VendorProfileController::class, 'updateProfile'])->name('profile.update'); // vendor.profile.update
Route::post('/profile', [VendorProfileController::class, 'updatePassword'])->name('profile.update.password'); // vendor.profile.update.password

/** Vendor Shop Profile */
Route::resource('shop-profile', VendorShopProfileController::class);
