<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Models\ChildCategory;
use Illuminate\Support\Facades\Route;

/** Admin Routes */
Route::redirect('/', '/admin/dashboard', 302);
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

/** Profile Routes */
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');

/** Slider Route */
Route::resource('/slider', SliderController::class);

/** Category Route */
/** We have to put additional routes before the resource route if we
 * want to use the same controller. Otherwise the route will not work */
Route::put('/category/change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::get('/category/sub-categories', [CategoryController::class, 'getSubCategories'])->name('category.sub-categories');
Route::resource('category', CategoryController::class);
/** Sub Category Route */
Route::put('/sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category.change-status');
Route::resource('sub-category', SubCategoryController::class);
/** Child Category Route */
Route::put('/child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::resource('child-category', ChildCategoryController::class);
