<?php

namespace App\Http\Controllers;

use App\Models\image_item_galleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/*
|--------------------------------------------------------------------------
| CRUD Tabel image_item_galleri
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel image_item_galleri. Dapat diakses dalam
| router grup "/imageitemgalleri".
|
| - LIST - Menampilkan daftar image_item_galleri
| - DETAIL - Menampilkan detail data image_item_galleri
| - CREATE - Membuat data image_item_galleri baru
| - UPDATE - Memperbarui data image_item_galleri
| - DELETE - Menghapus data image_item_galleri
|
*/

class imageitemgalleriController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel image_item_galleri gak ada isi maka 
        if (image_item_galleri::count() > 0) {
            $data = image_item_galleri::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Image berhasil diambil',
                '__func' => 'Image List',
            ], 200);
        }

        return response()->json([
            'data' => 'Image tidak ditemukan',
            '__message' => 'Image Artikel berhasil diambil',
            '__func' => 'Image List',
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
            'id_galleri' => ['required'],
            'description' => ['string'],
            'foto' => ['mimes:jpg,png,jpeg'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Image tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Image create',
            ], 422);
        }

        // Cek jika variabel "$request->foto" merupakan sebuah file
        if ($request->hasFile('foto')) {

            // Upload file gambar kedalam folder public dan kembalikan nama file 
            $nama_file = $this->uploadFile($request->foto);

        }

        // Eksekusi pembuatan data image_item_galleri
        $query = image_item_galleri::create([
            
            // 'id_users' => $request->id_users,
            'id_galleri' =>  $request->id_galleri,
            'description' =>  $request->description,
            'foto' => $nama_file,
    
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Image berhasil dibuat',
                '__func' => 'Image create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Image tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Image create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_image)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_galleri' => ['required'],
            'description' => ['string'],
            'foto' => ['mimes:jpg,png,jpeg'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Image tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'Image update',
            ], 422);
        }

        // Cek jika ID image_item_galleri yang diberikan merupakan Integer
        if (!is_numeric($id_image)){
            return response()->json([
                'data' => 'ID Image: ' . $id_image,
                '__message' => 'Image tidak berhasil diperbarui, ID Image harus berupa Integer',
                '__func' => 'Image update',
            ], 422);
        }

        // Cek jika ID image_item_galleri yang diberikan apakah tersedia di tabel
        if (image_item_galleri::where('id', $id_image)->exists()) {

            // Cek jika variabel "$request->foto" merupakan sebuah file
            if ($request->hasFile('foto')) {

                // Upload file gambar kedalam folder public dan kembalikan nama file 
                $nama_file = $this->uploadFile($request->foto);

                // Eksekusi pembaruan data image_item_galleri
                $query = image_item_galleri::where('id', $id_image)->update([
                    'id_galleri' =>  $request->id_galleri,
                    'description' =>  $request->description,
                    'foto' => $nama_file,
                ]);
            } else {

                 // Eksekusi pembaruan data image_item_galleri tanpa "foto"
                 $query = image_item_galleri::where('id', $id_image)->update([
                    'id_galleri' =>  $request->id_galleri,
                    'description' =>  $request->description,
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Image berhasil diperbarui',
                    '__func' => 'Image update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Image tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Image update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Image: ' . $id_image,
            '__message' => 'Image tidak berhasil diperbarui, ID Image tidak ditemukan',
            '__func' => 'Image update',
        ], 500);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_image)
    {
        // Cek jika ID image_item_galleri yang diberikan merupakan Integer
        if (!is_numeric($id_image)){
            return response()->json([
                'data' => 'ID Image: ' . $id_image,
                '__message' => 'Image tidak berhasil diambil, ID Image harus berupa Integer',
                '__func' => 'Image detail',
            ], 422);
        }

        // Cek jika ID image_item_galleri yang diberikan apakah tersedia di tabel
        if (image_item_galleri::where('id', $id_image)->exists()) {

            // Eksekusi pembaruan data image_item_galleri
            $query =image_item_galleri::where('id', $id_image)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Image berhasil diambil',
                    '__func' => 'Image detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Image tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Image detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Image: ' . $id_image,
            '__message' => 'Image tidak berhasil diambil, ID Image tidak ditemukan',
            '__func' => 'Image detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_image)
    {
        // Cek jika ID image_item_galleri yang diberikan merupakan Integer
        if (!is_numeric($id_image)){
            return response()->json([
                'data' => 'ID Image: ' . $id_image,
                '__message' => 'Image tidak berhasil dihapus, ID Image harus berupa Integer',
                '__func' => 'Image delete',
            ], 422);
        }

        // Cek jika ID image_item_galleri yang diberikan apakah tersedia di tabel
        if (image_item_galleri::where('id', $id_image)->exists()) {

            // Eksekusi penghapusan data image_item_galleri
            $query = image_item_galleri::where('id', $id_image)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Image berhasil dihapus',
                    '__func' => 'Image delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Image tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Image delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Image: ' . $id_image,
            '__message' => 'Image tidak berhasil dihapus, ID Image tidak ditemukan',
            '__func' => 'Image delete',
        ], 500);
    }
    
}
