<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductAttributeValueController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('category',CategoryController::class)->except('update','destroy');
Route::put('category',[CategoryController::class,'update'])->name("category.update");
Route::delete('category',[CategoryController::class,'destroy'])->name("category.destroy");

Route::apiResource('products',ProductController::class)->except('update','destroy');
Route::put('products',[ProductController::class,'update'])->name("product.update");
Route::delete('products',[ProductController::class,'destroy'])->name("product.destroy");


Route::group(['prefix' => '/products/{product}'],function(){
    Route::apiResource('product_attribute_value',ProductAttributeValueController::class)->except('update','destroy');
    Route::put('product_attribute_value',[ProductAttributeValueController::class,'update'])->name("product_attribute_value.update");
    Route::delete('product_attribute_value',[ProductAttributeValueController::class,'destroy'])->name("product_attribute_value.destroy");
});

Route::group(['prefix' => '/category/{category}'], function () {
    Route::apiResource('product_attribute',ProductAttributeController::class)->except('update','destroy');
    Route::put('product_attribute',[ProductAttributeController::class,'update'])->name("product_attribute.update");
    Route::delete('product_attribute',[ProductAttributeController::class,'destroy'])->name("product_attribute.destroy");
    
    Route::get('products',[ProductController::class,'show_products_in_category'])->name("category.product.show");
});

