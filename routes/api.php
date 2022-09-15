<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\artikelController;
use App\Http\Controllers\artikelhitController;
use App\Http\Controllers\artikelkategoriController;
use App\Http\Controllers\newsController;
use App\Http\Controllers\newshitController;
use App\Http\Controllers\newskategoriController;
use App\Http\Controllers\dokumenController;
use App\Http\Controllers\dokumenitemController;
use App\Http\Controllers\imagegalleriController;
use App\Http\Controllers\imageitemgalleriController;
use App\Http\Controllers\videogalleriController;
use App\Http\Controllers\videoitemgalleriController;
use App\Http\Controllers\staticpageController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\menuController;

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
        Route::patch('/{id_ukm}', [UkmController::class, 'update']); // Memperbarui UKM
        Route::post('/{id_ukm}', [UkmController::class, 'create']); // Membuat data UKM baru
        Route::delete('/{id_ukm}', [UkmController::class, 'delete']); // Menghapus data UKM
    });


    Route::prefix('artikelkategori')->group(function () {
  
        Route::patch('/{id_kategori}', [artikelkategoriController::class, 'update']); // Memperbarui artikelkategori
        Route::post('/{id_kategori}', [artikelkategoriController::class, 'create']); // Membuat data artikelkategori baru
        Route::delete('/{id_kategori}', [artikelkategoriController::class, 'delete']); // Menghapus data artikelkategori
    });

    Route::prefix('artikel')->group(function () {

        Route::patch('/{id_artikel}', [artikelController::class, 'update']); // Memperbarui artikel
        Route::post('/{id_artikel}', [artikelController::class, 'create']); // Membuat data artikel baru
        Route::delete('/{id_artikel}', [artikelController::class, 'delete']); // Menghapus data artikel
    });

    Route::prefix('artikelhit')->group(function () {
    
        Route::patch('/{id_artikel_hit}', [artikelhitController::class, 'update']); // Memperbarui artikelhit
        Route::post('/{id_artikel_hit}', [artikelhitController::class, 'create']); // Membuat data artikelhit baru
        Route::delete('/{id_artikel_hit}', [artikelhitController::class, 'delete']); // Menghapus data artikelhit
    });

    Route::prefix('newskategori')->group(function () {
       
        Route::patch('/{id_kategori}', [newskategoriController::class, 'update']); // Memperbarui newskategori
        Route::post('/{id_kategori}', [newskategoriController::class, 'create']); // Membuat data newskategori baru
        Route::delete('/{id_kategori}', [newskategoriController::class, 'delete']); // Menghapus data newskategori
    });

    Route::prefix('news')->group(function () {

        Route::patch('/{id_news}', [newsController::class, 'update']); // Memperbarui news
        Route::post('/{id_news}', [newsController::class, 'create']); // Membuat data news baru
        Route::delete('/{id_news}', [newsController::class, 'delete']); // Menghapus data news
    });

    Route::prefix('newshit')->group(function () {
     
        Route::patch('/{id_news_hit}', [newshitController::class, 'update']); // Memperbarui newshit
        Route::post('/{id_news_hit}', [newshitController::class, 'create']); // Membuat data newshit baru
        Route::delete('/{id_news_hit}', [newshitController::class, 'delete']); // Menghapus data newshit
    });

    Route::prefix('dokumen')->group(function () {
 
        Route::patch('/{id_dokumen}', [dokumenController::class, 'update']); // Memperbarui dokumen
        Route::post('/{id_dokumen}', [dokumenController::class, 'create']); // Membuat data dokumen baru
        Route::delete('/{id_dokumen}', [dokumenController::class, 'delete']); // Menghapus data dokumen
    });
    
    Route::prefix('dokumenitem')->group(function () {
  
        Route::patch('/{id_dokumen}', [dokumenitemController::class, 'update']); // Memperbarui dokumenitem
        Route::post('/{id_dokumen}', [dokumenitemController::class, 'create']); // Membuat data dokumenitem baru
        Route::delete('/{id_dokumen}', [dokumenitemController::class, 'delete']); // Menghapus data dokumenitem
    });

    
    Route::prefix('imagegalleri')->group(function () {
     
        Route::patch('/{id_image_galleri}', [imagegalleriController::class, 'update']); // Memperbarui imagegalleri
        Route::post('/{id_image_galleri}', [imagegalleriController::class, 'create']); // Membuat data imagegalleri baru
        Route::delete('/{id_image_galleri}', [imagegalleriController::class, 'delete']); // Menghapus data imagegalleri
    });

    Route::prefix('image')->group(function () {
        
        Route::patch('/{id_image}', [imageitemgalleriController::class, 'update']); // Memperbarui image
        Route::post('/{id_image}', [imageitemgalleriController::class, 'create']); // Membuat data image baru
        Route::delete('/{id_image}', [imageitemgalleriController::class, 'delete']); // Menghapus data image
    });

    Route::prefix('videogalleri')->group(function () {
     
        Route::patch('/{id_video_galleri}', [videogalleriController::class, 'update']); // Memperbarui videogalleri
        Route::post('/{id_video_galleri}', [videogalleriController::class, 'create']); // Membuat data videogalleri baru
        Route::delete('/{id_video_galleri}', [videogalleriController::class, 'delete']); // Menghapus data videogalleri
    });

    Route::prefix('video')->group(function () {
    
        Route::patch('/{id_video}', [videoitemgalleriController::class, 'update']); // Memperbarui video
        Route::post('/{id_video}', [videoitemgalleriController::class, 'create']); // Membuat data video baru
        Route::delete('/{id_video}', [videoitemgalleriController::class, 'delete']); // Menghapus data video
    });
    
    Route::prefix('staticpage')->group(function () {
     
        Route::patch('/{id_static_page}', [staticpageController::class, 'update']); // Memperbarui staticpage
        Route::post('/{id_static_page}', [staticpageController::class, 'create']); // Membuat data staticpage baru
        Route::delete('/{id_static_page}', [staticpageController::class, 'delete']); // Menghapus data staticpage
    });

    Route::prefix('menu')->group(function () {
 
        Route::patch('/{id_menu}', [menuController::class, 'update']); // Memperbarui menu
        Route::post('/{id_menu}', [menuController::class, 'create']); // Membuat data menu baru
        Route::delete('/{id_menu}', [menuController::class, 'delete']); // Menghapus data staticpage
        Route::get('/allmenu', [menuController::class, 'allmenu']);
      
        
    });
    
});


Route::prefix('ukm')->group(function () {
    Route::get('/', [UkmController::class, 'list'])->name('List'); // Daftar UKM
    Route::get('/{id_ukm}', [UkmController::class, 'detail']); // Detail Data UKM
});


Route::prefix('artikelkategori')->group(function () {
    Route::get('/', [artikelkategoriController::class, 'list']); // Daftar artikelkategori
    Route::get('/{id_kategori}', [artikelkategoriController::class, 'detail']); // Detail Data artikelkategori
});

Route::prefix('artikel')->group(function () {
    Route::get('/', [artikelController::class, 'list']); // Daftar artikel
    Route::get('/{id_artikel}', [artikelController::class, 'detail']); // Detail Data artikel
});

Route::prefix('artikelhit')->group(function () {
    Route::get('/', [artikelhitController::class, 'list']); // Daftar artikelhit
    Route::get('/{id_artikel_hit}', [artikelhitController::class, 'detail']); // Detail Data artikelhit
});

Route::prefix('newskategori')->group(function () {
    Route::get('/', [newsController::class, 'list']); // Daftar news
    Route::get('/{id_news}', [newsController::class, 'detail']); // Detail Data news
   
});

Route::prefix('news')->group(function () {
    Route::get('/', [newsController::class, 'list']); // Daftar news
    Route::get('/{id_news}', [newsController::class, 'detail']); // Detail Data news
});


Route::prefix('newshit')->group(function () {
    Route::get('/', [newshitController::class, 'list']); // Daftar newshit
    Route::get('/{id_news_hit}', [newshitController::class, 'detail']); // Detail Data newshit
});

Route::prefix('dokumen')->group(function () {
    Route::get('/', [dokumenController::class, 'list']); // Daftar dokumen
    Route::get('/{id_dokumen}', [dokumenController::class, 'detail']); // Detail Data dokumen
});

Route::prefix('dokumenitem')->group(function () {
    Route::get('/', [dokumenitemController::class, 'list']); // Daftar dokumenitem
    Route::get('/{id_dokumen}', [dokumenitemController::class, 'detail']); // Detail Data dokumenitem

});
Route::prefix('imagegalleri')->group(function () {
    Route::get('/', [imagegalleriController::class, 'list']); // Daftar imagegalleri
    Route::get('/{id_image_galleri}', [imagegalleriController::class, 'detail']); // Detail Data imagegalleri
});

Route::prefix('image')->group(function () {
    Route::get('/', [imageitemgalleriController::class, 'list']); // Daftar image
    Route::get('/{id_image}', [imageitemgalleriController::class, 'detail']); // Detail Data image
});

Route::prefix('videogalleri')->group(function () {
    Route::get('/', [videogalleriController::class, 'list']); // Daftar videogalleri
    Route::get('/{id_video_galleri}', [videogalleriController::class, 'detail']); // Detail Data videogalleri

});

Route::prefix('video')->group(function () {
    Route::get('/', [videoitemgalleriController::class, 'list']); // Daftar video
    Route::get('/{id_video}', [videoitemgalleriController::class, 'detail']); // Detail Data video
});


Route::prefix('staticpage')->group(function () {
    Route::get('/', [staticpageController::class, 'list']); // Daftar staticpage
    Route::get('/{id_static_page}', [staticpageController::class, 'detail']); // Detail Data staticpage

});

Route::prefix('menu')->group(function () {
    Route::get('/', [menuController::class, 'list']); // Daftar menu
    Route::get('/{id_menu}', [menuController::class, 'detail']); // Detail Data menu
  
    
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



