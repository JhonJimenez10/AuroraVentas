<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailSalesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\ReportsProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;



//Crear un usuario administrador por defecto
//Route::get('/create-admin', [AuthController::class, 'createAdminUser'])->name(name: 'create.admin');


Route::get('/', [AuthController::class, 'index'])->name(name: 'login');
Route::post('/login', [AuthController::class, 'login'])->name(name: 'login.post');

Route::middleware("auth")->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name(name: 'home');
    Route::get('/logout', [AuthController::class, 'logout'])->name(name: 'logout');
});

Route::prefix('sales')->middleware('auth')->group(function () {
    Route::get('/new-sale', [SalesController::class, 'index'])->name(name: 'sales.new-sale');
    Route::get('/add-cart/{id_product}', [SalesController::class, 'add_cart'])->name(name: 'sales.add-cart');
    Route::get('/delete-cart', [SalesController::class, 'delete_cart'])->name(name: 'sales.delete-cart');
    Route::get('/remove-cart/{id_product}', [SalesController::class, 'remove_cart'])->name(name: 'sales.remove-cart');
    Route::post('/store-sale', [SalesController::class, 'store'])->name(name: 'sales.store-sale');
});

Route::prefix('datail')->middleware('auth')->group(function () {
    Route::get('/detail-sale', [DetailSalesController::class, 'index'])->name(name: 'sales.detail-sale');
    Route::get('/detail-sale/{id}', [DetailSalesController::class, 'detail_sale'])->name(name: 'sales.detail-sale.id');
    Route::delete('/annul-sale/{id}', [DetailSalesController::class, 'annul_sale'])->name(name: 'sales.annul-sale.id');
    Route::get('/ticket/{id_sale}', [DetailSalesController::class, 'generateTicket'])->name(name: 'sales.detail.ticket');
});

Route::prefix('categories')->middleware('auth')->group(function () {
    Route::get('/', [CategoriesController::class, 'index'])->name(name: 'categories.index');
    Route::get('/create', [CategoriesController::class, 'create'])->name(name: 'categories.create');
    Route::post('/store', [CategoriesController::class, 'store'])->name(name: 'categories.store');
    Route::get('/show/{id}', [CategoriesController::class, 'show'])->name(name: 'categories.show');
    Route::delete('/destroy/{id}', [CategoriesController::class, 'destroy'])->name(name: 'categories.destroy');
    Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name(name: 'categories.edit');
    Route::put('/update/{id}', [CategoriesController::class, 'update'])->name(name: 'categories.update');
});

Route::prefix('products')->middleware('auth')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name(name: 'products.index');
    Route::get('/create', [ProductsController::class, 'create'])->name(name: 'products.create');
    Route::post('/store', [ProductsController::class, 'store'])->name(name: 'products.store');
    Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name(name: 'products.edit');
    Route::put('/update/{id}', [ProductsController::class, 'update'])->name(name: 'products.update');

    Route::get('/show-image/{id}', [ProductsController::class, 'show_image'])->name(name: 'products.show.image');
    Route::put('/update-image/{id}', [ProductsController::class, 'update_image'])->name(name: 'products.update.image');

    Route::get('/show/{id}', [ProductsController::class, 'show'])->name(name: 'products.show');
    Route::delete('/destroy/{id}', [ProductsController::class, 'destroy'])->name(name: 'products.destroy');
    Route::get('/update-active/{id}/{active}', [ProductsController::class, 'active'])->name(name: 'products.active');
});

Route::prefix('reports_products')->middleware('auth')->group(function () {
    Route::get('/', [ReportsProductsController::class, 'index'])->name(name: 'reports_products.index');
    Route::get('/out_of_stock', [ReportsProductsController::class, 'out_of_stock'])->name(name: 'reports_products.out_of_stock');
});

Route::prefix('providers')->middleware('auth')->group(function () {
    Route::get('/', [ProvidersController::class, 'index'])->name(name: 'providers.index');
    Route::get('/create', [ProvidersController::class, 'create'])->name(name: 'providers.create');
    Route::post('/store', [ProvidersController::class, 'store'])->name(name: 'providers.store');
    Route::get('/edit/{id}', [ProvidersController::class, 'edit'])->name(name: 'providers.edit');
    Route::put('/update/{id}', [ProvidersController::class, 'update'])->name(name: 'providers.update');
    Route::delete('/destroy/{id}', [ProvidersController::class, 'destroy'])->name(name: 'providers.destroy');
    Route::get('/show/{id}', [ProvidersController::class, 'show'])->name(name: 'providers.show');
});

Route::prefix('users')->middleware('auth')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name(name: 'users.index');
    Route::get('/create', [UsersController::class, 'create'])->name(name: 'users.create');
    Route::post('/store', [UsersController::class, 'store'])->name(name: 'users.store');
    Route::get('/edit/{id}', [UsersController::class, 'edit'])->name(name: 'users.edit');
    Route::put('/update/{id}', [UsersController::class, 'update'])->name(name: 'users.update');
    Route::get('/tbody', [UsersController::class, 'tbody'])->name(name: 'users.tbody');
    Route::get('/update-active/{id}/{active}', [UsersController::class, 'active'])->name(name: 'users.active');
    Route::get('/update-password/{id}/{password}', [UsersController::class, 'update_password'])->name(name: 'users.update-password');
});
Route::prefix('shopping')->middleware('auth')->group(function () {
    Route::get('/', [ShoppingController::class, 'index'])->name(name: 'shopping.index');
    Route::get('/create/{id_product}', [ShoppingController::class, 'create'])->name(name: 'shopping.create');
    Route::post('/store', [ShoppingController::class, 'store'])->name(name: 'shopping.store');
    Route::get('/edit/{id}', [ShoppingController::class, 'edit'])->name(name: 'shopping.edit');
    Route::put('/update/{id}', [ShoppingController::class, 'update'])->name(name: 'shopping.update');
    Route::get('/show/{id}', [ShoppingController::class, 'show'])->name(name: 'shopping.show');
    Route::delete('/destroy/{id}', [ShoppingController::class, 'destroy'])->name(name: 'shopping.destroy');
});
Route::prefix('customers')->middleware('auth')->group(function () {
    Route::get('/', [CustomersController::class, 'index'])->name(name: 'customers.index');
    Route::get('/create', [CustomersController::class, 'create'])->name(name: 'customers.create');
    Route::post('/store', [CustomersController::class, 'store'])->name(name: 'customers.store');
    Route::get('/edit/{customer}', [CustomersController::class, 'edit'])->name(name: 'customers.edit');
    Route::put('/update/{customer}', [CustomersController::class, 'update'])->name(name: 'customers.update');
    Route::delete('/destroy/{customer}', [CustomersController::class, 'destroy'])->name(name: 'customers.destroy');

    // (Opcional) endpoint para autocompletar clientes en formularios de venta
    Route::get('/search', [CustomersController::class, 'search'])->name(name: 'customers.search');
});
