<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ukmController;
use App\Http\Controllers\artikelController;
use App\Http\Controllers\artikelhitController;
use App\Http\Controllers\artikelkategoriController;
use App\Http\Controllers\dokumenController;
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
Route::get('/ukm', [ukmController::class, 'index']);
Route::post('/ukm', [ukmController::class, 'store']);
Route::get('/ukm/{id}', [ukmController::class, 'show']);
Route::post('/ukm/{id}', [ukmController::class, 'update']);
Route::delete('/ukm/{id}', [ukmController::class, 'delete']);

Route::get('/artikel', [artikelController::class, 'index']);
// Route::get('/artikel{id}', [artikelController::class, 'show']);

Route::get('/artikel_hit', [artikelhitController::class, 'index']);
// Route::get('/artikel_hit{id}', [artikelhitController::class, 'show']);


Route::get('/artikel_kategori', [artikelkategoriController::class, 'index']);
Route::post('/artikel_kategori', [artikelkategoriController::class, 'store']);
Route::get('/artikel_kategori/{id}', [artikelkategoriController::class, 'show']);
Route::post('/artikel_kategori/{id}', [artikelkategoriController::class, 'update']);
Route::delete('/artikel_kategori/{id}', [artikelkategoriController::class, 'delete']);

Route::get('/dokumen', [dokumenController::class, 'index']);
























Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']); 

});



