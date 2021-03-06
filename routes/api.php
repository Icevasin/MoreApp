<?php
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RecordController;
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
Route::resource('brands',BrandController::class);
Route::get('/brands/search/{name}',[BrandController::class, 'search']);

Route::resource('models',CarModelController::class);
Route::get('/models/search/{name}',[CarModelController::class, 'search']);

Route::resource('employee',EmployeeController::class);
Route::get('/employee/search/{name}',[EmployeeController::class, 'search']);

Route::resource('record',RecordController::class);
Route::get('/record/search/{name}',[RecordController::class, 'search']);

Route::post('/record/searchone',[RecordController::class, 'searchone']);
Route::post('/record/searchtwo',[RecordController::class, 'searchtwo']);
Route::post('/record/searchthree',[RecordController::class, 'searchthree']);

// Route::get('/brands',[BrandController::class, 'index']);
// Route::post('/brands',[BrandController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
