<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarCategoryController;
use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\OrderController;

/**
 * Get authenticated user (requires Sanctum token)
 */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// =========================
// || Car Categories Routes ||
// =========================

/**
 * Get all car category names
 */
Route::get('/carCategories/all/name', [CarCategoryController::class, 'listallname']);

/**
 * Get all car category IDs
 */
Route::get('/carCategories/all/id', [CarCategoryController::class, 'listallid']);

/**
 * Get all car categories (full data)
 */
Route::get('/carCategories/all', [CarCategoryController::class, 'all']);

/**
 * Get a single car category by ID (sent in request body)
 */
Route::post('/carCategories', [CarCategoryController::class, 'show']);

/**
 * Create a new car category
 */
Route::post('/carCategories/create', [CarCategoryController::class, 'store']);

/**
 * Update an existing car category
 */
Route::put('/carCategories', [CarCategoryController::class, 'update']);

/**
 * Delete a car category
 */
Route::delete('/carCategories', [CarCategoryController::class, 'destroy']);


// =========================
// || Cars Routes ||
// =========================

/**
 * Get cars filtered by category name
 */
Route::post('/car/category', [CarController::class, 'allcategory']);

/**
 * Get a single car by ID
 */
Route::post('/car', [CarController::class, 'show']);

/**
 * Get all cars (full data with relationships)
 */
Route::get('/car/all', [CarController::class, 'all']);

/**
 * Get all car IDs
 */
Route::get('/car/all/id', [CarController::class, 'listallid']);

/**
 * Get all car names
 */
Route::get('/car/all/name', [CarController::class, 'listallname']);

/**
 * Search cars by name (partial match)
 */
Route::post('/car/search', [CarController::class, 'search']);

/**
 * Update an existing car
 */
Route::put('/car', [CarController::class, 'update']);

/**
 * Delete a car
 */
Route::delete('/car', [CarController::class, 'destroy']);

/**
 * Create a new car
 */
Route::post('/car/create', [CarController::class, 'store']);


// =========================
// || Orders Routes ||
// =========================

/**
 * Create a new order (includes items, personal info, location)
 */
Route::post('/Orders/create', [OrderController::class, 'store']);