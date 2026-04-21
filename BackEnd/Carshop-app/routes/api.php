<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarCategoryController;
use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\OrderController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ||Car Categories|| \\
Route::get('/carCategories/all/name', [CarCategoryController::class,'listallname']);
Route::get('/carCategories/all/id', [CarCategoryController::class,'listallid']);
Route::get('/carCategories/all', [CarCategoryController::class,'all']);
Route::post('/carCategories', [CarCategoryController::class,'show']);
Route::post('/carCategories/create', [CarCategoryController::class, 'store']);
Route::put('/carCategories', [CarCategoryController::class, 'update']);
Route::delete('/carCategories', [CarCategoryController::class, 'destroy']);

// ||Cars|| \\

Route::post('/car/category', [CarController::class, 'allcategory']);
Route::post('/car', [CarController::class,'show']);

Route::get('/car/all', [CarController::class,'all']);
Route::get('/car/all/id', [CarController::class,'listallid']);
Route::get('/car/all/name', [CarController::class,'listallname']);
Route::post('/car/search', [CarController::class,'search']);
Route::put('/car', [CarController::class, 'update']);
Route::delete('/car', [CarController::class, 'destroy']);
Route::post('/car/create', [CarController::class,'store']);

// || Orders || \\ 

Route::post('/Orders/create', [OrderController::class, 'store']);