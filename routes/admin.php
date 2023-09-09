<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;

/** Admin Routes */
Route::redirect('/', '/admin/dashboard', 302);
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

/** Profile Routes */
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');

/** Slider Routes */
Route::resource('slider', SliderController::class);

/** Category Routes */
/** We have to put additional routes before the resource route if we
 * want to use the same controller. Otherwise the route will not work */
Route::put('/category/change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::get('/category/sub-categories', [CategoryController::class, 'getSubCategories'])->name('category.sub-categories');
Route::resource('category', CategoryController::class);
/** Sub Category Routes */
Route::put('/sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category.change-status');
Route::get('/sub-category/child-categories', [SubCategoryController::class, 'getChildCategories'])->name('sub-category.child-categories');
Route::resource('sub-category', SubCategoryController::class);
/** Child Category Routes */
Route::put('/child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::resource('child-category', ChildCategoryController::class);

/** Brand Routes */
Route::put('/brand/change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
Route::resource('brand', BrandController::class);

/** Vendor Profile Routes */
Route::resource('vendor-profile', AdminVendorProfileController::class);

/** Product Image Gallery Routes */
Route::resource('product/image-gallery', ProductImageGalleryController::class);

/** Product Variant Item Routes */
Route::get('/product/variant/{variant_id}/item/create', [ProductVariantItemController::class, 'create'])->name('variant-item.create');
Route::get('/product/variant/{variant_id}/item/{id}/edit', [ProductVariantItemController::class, 'edit'])->name('variant-item.edit');
Route::get('/product/variant/{variant_id}/item', [ProductVariantItemController::class, 'index'])->name('variant-item.index');
Route::post('/product/variant/{variant_id}/item', [ProductVariantItemController::class, 'store'])->name('variant-item.store');
Route::delete('/product/variant/{variant_id}/item', [ProductVariantItemController::class, 'destroy'])->name('variant-item.destroy');

/** Product Variant Routes */
Route::put('/product/variant/change-status', [ProductVariantController::class, 'changeStatus'])->name('variant.change-status');
Route::resource('product/variant', ProductVariantController::class);

/** Product Routes */
Route::put('/product/change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
Route::resource('product', ProductController::class);
