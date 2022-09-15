<?php

namespace App\Http\Controllers;

use App\Models\artikel_kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| CRUD Tabel Artikel kategori
|--------------------------------------------------------------------------
|
| ArtikelkategoriController digunakan untuk mengelola tabel Artikel_kategori. Dapat diakses dalam
| router grup "/artikel_kategori".
|
| - LIST - Menampilkan daftar Artikel_kategori
| - DETAIL - Menampilkan detail data Artikel_kategori
| - CREATE - Membuat data Artikel_kategori baru
| - UPDATE - Memperbarui data Artikel_kategori
| - DELETE - Menghapus data Artikel_kategori
|
*/

class artikelkategoriController extends Controller
{ /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel Artikel_kategori gak ada isi maka 
        if (artikel_kategori::count() > 0) {
          
            $data = artikel_kategori::get();

        // if   $query = artikel_kategori::where('id_ukm', $request->id_ukm)->get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Artikel kategori berhasil diambil',
                '__func' => 'Artikel kategori List',
            ], 200);
        }

        return response()->json([
            'data' => 'Artikel kategori tidak ditemukan',
            '__message' => 'Daftar Artikel kategori berhasil diambil',
            '__func' => 'Artikel kategori List',
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_ukm' =>['required',],
            'nama_kategori' => ['required', 'string', 'min:3'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Kategori tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Kategori create',
            ], 422);
        }

    

        // Eksekusi pembuatan data artikel_kategori
        $query = artikel_kategori::create([
            'id_ukm' => $request->id_ukm,
            'nama_kategori' => $request->nama_kategori,
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Katgeori berhasil dibuat',
                '__func' => 'Kategori create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Kategori tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Kategori create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_kategori)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_ukm' => ['required'],
            'nama_kategori' => ['string', 'min:3'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Artikel_kategori tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'Artikel_kategori update',
            ], 422);
        }

        // Cek jika ID Artikel_kategori yang diberikan merupakan Integer
        if (!is_numeric($id_kategori)){
            return response()->json([
                'data' => 'ID Kategori: ' . $id_kategori,
                '__message' => 'Artikel_kategori tidak berhasil diperbarui, ID KATEGORI harus berupa Integer',
                '__func' => 'Artikel_kategori update',
            ], 422);
        }

        // Cek jika ID Artikel_kategori yang diberikan apakah tersedia di tabel
        if (artikel_kategori::where('id', $id_kategori)->exists()) {

          {

                 // Eksekusi pembaruan data artikel kategori
                 $query = artikel_kategori::where('id', $id_kategori)->update([
                    'nama_kategori' => $request->nama_kategori,
                  
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Artikel_kategori berhasil diperbarui',
                    '__func' => 'Artikel_kategori update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Artikel_kategori tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Artikel_kategori update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Kategori: ' . $id_kategori,
            '__message' => 'Id Kategori tidak berhasil diperbarui, ID UKM tidak ditemukan',
            '__func' => 'Artikel_kategori update',
        ], 500);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_kategori)
    {
        // Cek jika ID Kategori yang diberikan merupakan Integer
        if (!is_numeric($id_kategori)){
            return response()->json([
                'data' => 'ID Kategori: ' . $id_kategori,
                '__message' => 'Kategori tidak berhasil diambil, ID Kategori harus berupa Integer',
                '__func' => 'Kategori detail',
            ], 422);
        }

        // Cek jika ID kategori yang diberikan apakah tersedia di tabel
        if (artikel_kategori::where('id', $id_kategori)->exists()) {

            // Eksekusi pembaruan data kategori
            $query = artikel_kategori::where('id', $id_kategori)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Kategori berhasil diambil',
                    '__func' => 'Kategori detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Kategori tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Kategori detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Kategori: ' . $id_kategori,
            '__message' => 'Kategori tidak berhasil diambil, ID UKM tidak ditemukan',
            '__func' => 'Kategori detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_kategori)
    {
        // Cek jika ID Kategori yang diberikan merupakan Integer
        if (!is_numeric($id_kategori)){
            return response()->json([
                'data' => 'ID Kategori: ' . $id_kategori,
                '__message' => 'Kategori tidak berhasil dihapus, ID Kategori harus berupa Integer',
                '__func' => 'Kategori delete',
            ], 422);
        }

        // Cek jika ID Kategori yang diberikan apakah tersedia di tabel
        if (artikel_kategori::where('id', $id_kategori)->exists()) {

            // Eksekusi penghapusan data Kategori
            $query = artikel_kategori::where('id', $id_kategori)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Kategori berhasil dihapus',
                    '__func' => 'Kategori delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Kategori tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Kategori delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Kategori: ' . $id_kategori,
            '__message' => 'Kategori tidak berhasil dihapus, ID Kategori tidak ditemukan',
            '__func' => 'Kategori delete',
        ], 500);
    }
}