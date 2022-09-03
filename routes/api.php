<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\artikelController;
use App\Http\Controllers\artikelhitController;
use App\Http\Controllers\artikelkategoriController;
use App\Http\Controllers\newsController;
use App\Http\Controllers\newskategoriController;
use App\Http\Controllers\dokumenController;
use App\Http\Controllers\imagegalleriController;
use App\Http\Controllers\imageitemgalleriController;
use App\Http\Controllers\videogalleriController;
use App\Http\Controllers\videoitemgalleriController;
use App\Http\Controllers\staticpageController;
use App\Http\Controllers\UkmController;

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

Route::post('/login', [AuthController::class, 'login']); // Login User
Route::post('/register', [AuthController::class, 'register']); // Membuat data User baru

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::prefix('ukm')->group(function () {
        Route::get('/', [UkmController::class, 'list']); // Daftar UKM
        Route::get('/{id_ukm}', [UkmController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_ukm}', [UkmController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_ukm}', [UkmController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_ukm}', [UkmController::class, 'delete']); // Menghapus data UKM
    });


    Route::prefix('artikelkategori')->group(function () {
        Route::get('/', [artikelkategoriController::class, 'list']); // Daftar UKM
        Route::get('/{id_kategori}', [artikelkategoriController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_kategori}', [artikelkategoriController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_kategori}', [artikelkategoriController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_kategori}', [artikelkategoriController::class, 'delete']); // Menghapus data UKM
    });

    Route::prefix('artikel')->group(function () {
        Route::get('/', [artikelController::class, 'list']); // Daftar UKM
        Route::get('/{id_artikel}', [artikelController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_artikel}', [artikelController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_artikel}', [artikelController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_artikel}', [artikelController::class, 'delete']); // Menghapus data UKM
    });

    Route::prefix('newskategori')->group(function () {
        Route::get('/', [newskategoriController::class, 'list']); // Daftar UKM
        Route::get('/{id_kategori}', [newskategoriController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_kategori}', [newskategoriController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_kategori}', [newskategoriController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_kategori}', [newskategoriController::class, 'delete']); // Menghapus data UKM
    });

    Route::prefix('news')->group(function () {
        Route::get('/', [newsController::class, 'list']); // Daftar UKM
        Route::get('/{id_news}', [newsController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_news}', [newsController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_news}', [newsController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_news}', [newsController::class, 'delete']); // Menghapus data UKM
    });

    Route::prefix('dokumen')->group(function () {
        Route::get('/', [dokumenController::class, 'list']); // Daftar UKM
        Route::get('/{id_dokumen}', [dokumenController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_dokumen}', [dokumenController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_dokumen}', [dokumenController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_dokumen}', [dokumenController::class, 'delete']); // Menghapus data UKM
    });
    
    Route::prefix('dokumenitem')->group(function () {
        Route::get('/', [dokumenitemController::class, 'list']); // Daftar UKM
        Route::get('/{id_dokumen}', [dokumenController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_dokumen}', [dokumenController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_dokumen}', [dokumenitemController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_dokumen}', [dokumenController::class, 'delete']); // Menghapus data UKM
    });

    
    Route::prefix('imagegalleri')->group(function () {
        Route::get('/', [imagegalleriController::class, 'list']); // Daftar UKM
        Route::get('/{id_image_galleri}', [imagegalleriController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_image_galleri}', [imagegalleriController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_image_galleri}', [imagegalleriController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_image_galleri}', [imagegalleriController::class, 'delete']); // Menghapus data UKM
    });

    Route::prefix('image')->group(function () {
        Route::get('/', [imageitemgalleriController::class, 'list']); // Daftar UKM
        Route::get('/{id_image}', [imageitemgalleriController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_image}', [imageitemgalleriController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_image}', [imageitemgalleriController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_image}', [imageitemgalleriController::class, 'delete']); // Menghapus data UKM
    });

    Route::prefix('videogalleri')->group(function () {
        Route::get('/', [videogalleriController::class, 'list']); // Daftar UKM
        Route::get('/{id_video_galleri}', [videogalleriController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_video_galleri}', [videogalleriController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_video_galleri}', [videogalleriController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_video_galleri}', [videogalleriController::class, 'delete']); // Menghapus data UKM
    });

    Route::prefix('video')->group(function () {
        Route::get('/', [videoitemgalleriController::class, 'list']); // Daftar UKM
        Route::get('/{id_video}', [videoitemgalleriController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_video}', [videoitemgalleriController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_video}', [videoitemgalleriController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_video}', [videoitemgalleriController::class, 'delete']); // Menghapus data UKM
    });
    
    Route::prefix('staticpage')->group(function () {
        Route::get('/', [staticpageController::class, 'list']); // Daftar UKM
        Route::get('/{id_static_page}', [staticpageController::class, 'detail']); // Detail Data UKM
        Route::patch('/{id_static_page}', [staticpageController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_static_page}', [staticpageController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_static_page}', [staticpageController::class, 'delete']); // Menghapus data UKM
    });
    
});




// Route::get('/artikel', [artikelController::class, 'index']);
// // Route::get('/artikel{id}', [artikelController::class, 'show']);

// Route::get('/artikel_hit', [artikelhitController::class, 'index']);
// // Route::get('/artikel_hit{id}', [artikelhitController::class, 'show']);


// Route::get('/artikel_kategori', [artikelkategoriController::class, 'index']);
// Route::post('/artikel_kategori', [artikelkategoriController::class, 'store']);
// Route::get('/artikel_kategori/{id}', [artikelkategoriController::class, 'show']);
// Route::post('/artikel_kategori/{id}', [artikelkategoriController::class, 'update']);
// Route::delete('/artikel_kategori/{id}', [artikelkategoriController::class, 'delete']);


























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



