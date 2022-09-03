<?php

namespace App\Http\Controllers;

use App\Models\image_galleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class imagegalleriController extends Controller
{/*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel artikel gak ada isi maka 
        if (image_galleri::count() > 0) {
            $data =image_galleri::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Imgae Galleri berhasil diambil',
                '__func' => 'Image Galleri List',
            ], 200);
        }

        return response()->json([
            'data' => 'Image Galleri tidak ditemukan',
            '__message' => 'Daftar Image Galleri berhasil diambil',
            '__func' => 'Image Galleri List',
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
            'nama' => ['required', 'string', 'min:3'],
            'description' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Image Galleri tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Image Galleri create',
            ], 422);
        }

    

        // Eksekusi pembuatan data artikel_kategori
        $query = image_galleri::create([
            'id_ukm' => $request->id_ukm,
            'nama' => $request->nama,
            'description' =>$request->description

        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Image Galleri berhasil dibuat',
                '__func' => 'Image Galleri create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Image Galleri tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Image Galleri create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_image_galleri)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
        
            'id_ukm' =>['required',],
            'nama' => ['required', 'string', 'min:3'],
            'description' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Image Galleri tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'Image Galleri  update',
            ], 422);
        }

        // Cek jika ID Artikel_kategori yang diberikan merupakan Integer
        if (!is_numeric($id_image_galleri)){
            return response()->json([
                'data' => 'ID Image Galleri: ' . $id_image_galleri,
                '__message' => 'Image Galleri tidak berhasil diperbarui, ID Imager Galleri harus berupa Integer',
                '__func' => 'Image Galleri update',
            ], 422);
        }

        // Cek jika ID Artikel_kategori yang diberikan apakah tersedia di tabel
        if (image_galleri::where('id', $id_image_galleri)->exists()) {

          {

                 // Eksekusi pembaruan data Dokumen
                 $query = image_galleri::where('id', $id_image_galleri)->update([
                    'id_ukm' => $request->id_ukm,
                    'nama' => $request->nama,
                    'description' =>$request->description        
                  
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Image Galleri berhasil diperbarui',
                    '__func' => 'Image Galleri update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Image Galleri tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Image Galleri update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Image Galleri: ' . $id_image_galleri,
            '__message' => 'Id Image galleri tidak berhasil diperbarui, ID Image Galleri tidak ditemukan',
            '__func' => 'Image Galleri update',
        ], 500);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_image_galleri)
    {
        // Cek jika ID Kategori yang diberikan merupakan Integer
        if (!is_numeric($id_image_galleri)){
            return response()->json([
                'data' => 'ID image Galleri: ' . $id_image_galleri,
                '__message' => 'Image Galleri tidak berhasil diambil, ID Image Galleri harus berupa Integer',
                '__func' => 'Image Galleri detail',
            ], 422);
        }

        // Cek jika ID kategori yang diberikan apakah tersedia di tabel
        if (image_galleri::where('id', $id_image_galleri)->exists()) {

            // Eksekusi pembaruan data kategori
            $query = image_galleri::where('id', $id_image_galleri)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Image Galleri berhasil diambil',
                    '__func' => 'Image Galleri detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Image Galleri tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Image Galleri detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Image Galleri' . $id_image_galleri,
            '__message' => 'Image Galleri tidak berhasil diambil, ID Image Galleri tidak ditemukan',
            '__func' => 'Image Galleri detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_image_galleri)
    {
        // Cek jika ID Kategori yang diberikan merupakan Integer
        if (!is_numeric($id_image_galleri)){
            return response()->json([
                'data' => 'ID Image Galleri: ' . $id_image_galleri,
                '__message' => 'Image Galleri tidak berhasil dihapus, ID Image Galleri harus berupa Integer',
                '__func' => 'Image Galleri delete',
            ], 422);
        }

        // Cek jika ID Kategori yang diberikan apakah tersedia di tabel
        if (image_galleri::where('id', $id_image_galleri)->exists()) {

            // Eksekusi penghapusan data Kategori
            $query = image_galleri::where('id', $id_image_galleri)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Image Galleri berhasil dihapus',
                    '__func' => 'Image Galleri delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Image Galleri tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Image Galleri delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Image Galleri : ' . $id_image_galleri,
            '__message' => 'Image Galleri tidak berhasil dihapus, ID Image Galleri tidak ditemukan',
            '__func' => 'Image Galleri delete',
        ], 500);
    }
}
