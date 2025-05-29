<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\front\AccountController;
use App\Http\Controllers\front\OrderController;
use \App\Http\Controllers\front\ProductController as FrontProductController;
use Illuminate\Support\Facades\Route;

//everyone can access these routes

Route::post('/admin/login',[AuthController::class,'authenticate']);
Route::get('get-latest-products',[FrontProductController::class,'latestProducts']);
Route::get('get-featured-products',[FrontProductController::class,'featuredProducts']);
Route::get('get-categories',[FrontProductController::class,'getCategories']);
Route::get('get-brands',[FrontProductController::class,'getBrands']);
Route::get('get-products',[FrontProductController::class,'getProducts']);
Route::get('get-product/{id}',[FrontProductController::class,'getProduct']);
Route::post('register',[AccountController::class,'register']);
Route::post('login',[AccountController::class,'authenticate']);
Route::get('get-shipping-front',[\App\Http\Controllers\front\ShippingController::class,'getShipping']);


//routes can access only loged-in user
Route::group(['middleware' => ['auth:sanctum','checkUserRole']],function(){
Route::post('save-order',[OrderController::class,'saveOrder']);
Route::get('get-order-details/{id}',[AccountController::class,'getOrderDetails']);
Route::get('get-orders',[AccountController::class,'getOrders']);
Route::get('/user/{id}/total-orders',[OrderController::class,'getTotalOrders']);

});


//routes can access only admin

Route::group(['middleware' => ['auth:sanctum','checkAdminRole']],function(){

    Route::resource('categories',CategoryController::class);
    Route::resource('brands',BrandController::class);
    Route::resource('products',ProductController::class);

    Route::get('sizes',[SizeController::class,'index']);
    Route::post('temp-images',[TempImageController::class,'store']);
    Route::post('save-product-image',[ProductController::class,'saveProductImage']);
    Route::get('change-product-default-image',[ProductController::class,'updateDefaultImage']);
    Route::delete('delete-product-image/{id}',[ProductController::class,'deleteProductImage']);
    

    Route::get('orders',[\App\Http\Controllers\admin\OrderController::class,'index']);
    Route::get('orders/{id}',[\App\Http\Controllers\admin\OrderController::class,'detail']);
    Route::post('update-order/{id}',[\App\Http\Controllers\admin\OrderController::class,'updateOrder']);


    Route::get('get-shipping',[ShippingController::class,'getShipping']);
    Route::post('save-shipping',[ShippingController::class,'updateShipping']);
    Route::get('/total-product',[ProductController::class,'getTotalActiveProducts']);
    Route::get('/total-order',[\App\Http\Controllers\admin\OrderController::class,'getTotalOrders']);
    
    

});
