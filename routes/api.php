<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    
Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');

Route::apiResource('/grades','App\Http\Controllers\Api\GradeController')->middleware('role:admin');
Route::apiResource('/users','App\Http\Controllers\Api\UserController');

Route::apiResource('/categories','App\Http\Controllers\Api\CategoryController');
Route::apiResource('/subcategories','App\Http\Controllers\Api\SubcategoryController');
Route::apiResource('/brands','App\Http\Controllers\Api\BrandController');

Route::apiResource('/products','App\Http\Controllers\Api\ProductController');
Route::apiResource('/percentages','App\Http\Controllers\Api\PercentageController');

Route::post('/order','App\Http\Controllers\Api\OrderController@order');
Route::get('/order_lists','App\Http\Controllers\Api\OrderController@order_lists');
Route::get('/order_history/{id}','App\Http\Controllers\Api\OrderController@order_history');

});
