<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Customer\ClientController ;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\HomeController;





Route::get('/', [HomeController::class,'index']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('logout',  [AuthController::class, 'logout'])->name('logout');
    Route::get('logout',  [AuthController::class, 'logout'])->name('logout');


    // Admin Routes
// Route untuk admin
// Route untuk admin
Route::group(['prefix' => 'admin'], function () {
    Route::controller(DashboardController::class)->group(function(){
        Route::get('dashboard', 'index')->name('admin.dashboard');

    });
    Route::controller(CategoryController::class)->group(function(){
        Route::get('categories', 'index')->name('admin.categories.index');
        Route::get('categories/create',  'create')->name('admin.categories.create');
        Route::post('categories',  'store')->name('admin.categories.store');
        Route::get('categories/{id}/edit',  'edit')->name('admin.categories.edit');
        Route::put('categories/{id}', 'update')->name('admin.categories.update');
        Route::delete('categories/{id}', 'destroy')->name('admin.categories.destroy');
    });
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('updateproduct');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::get('gallery/create', [GalleryController::class, 'create'])->name('admin.gallery.create');
    Route::post('gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::get('gallery/{id}/edit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
    Route::put('gallery/{id}', [GalleryController::class, 'update'])->name('updategallery');
    Route::delete('gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('news', [NewsController::class, 'index'])->name('admin.news.index');
    Route::get('news/create', [NewsController::class, 'create'])->name('admin.news.create');
    Route::post('news', [NewsController::class, 'store'])->name('admin.news.store');
    Route::get('news/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit');
    Route::put('news/{id}', [NewsController::class, 'update'])->name('admin.news.update');
    Route::delete('news/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
});


// Route untuk customer
    Route::controller(ClientController::class)->group(function(){
        Route::get('dashboard','index')->name('customer.dashboard');
        Route::get('/produk/category/{id}','CategoryPage')->name('category');
        Route::post('/add-to-cart', 'addToCart')->name('addtocart');
        Route::get('/produk','Product')->name('product');
        Route::get('/cart',  'showCart')->name('cart');
        Route::delete('/cart/{id}', 'destroyCart')->name('cart.delete');
        Route::get('/profile','Profile')->name('profile');
        Route::post('/', 'feedbackStore')->name('storefeedback');
        Route::get('/feedback','feedbackShow')->name('feedbackshow');
    });
