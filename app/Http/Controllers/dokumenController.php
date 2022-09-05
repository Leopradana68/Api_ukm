<?php

namespace App\Http\Controllers;


use App\Models\dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| CRUD Tabel Dokumen
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel artikel. Dapat diakses dalam
| router grup "/artikel".
|
| - LIST - Menampilkan daftar Dokumen
| - DETAIL - Menampilkan detail data Dokumen
| - CREATE - Membuat data Dokumen baru
| - UPDATE - Memperbarui data Dokumen
| - DELETE - Menghapus data Dokumen
|
*/

class dokumenController extends Controller
{/*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel Dokumen gak ada isi maka 
        if (dokumen::count() > 0) {
            $data =dokumen::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Dokumen berhasil diambil',
                '__func' => 'Dokumen List',
            ], 200);
        }

        return response()->json([
            'data' => 'Dokumen tidak ditemukan',
            '__message' => 'Daftar Dokumen berhasil diambil',
            '__func' => 'Dokumen List',
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
                '__message' => 'Dokumen tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Dokumen create',
            ], 422);
        }

    

        // Eksekusi pembuatan data Dokumen
        $query = dokumen::create([
            'id_ukm' => $request->id_ukm,
            'nama' => $request->nama,
            'description' =>$request->description

        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen berhasil dibuat',
                '__func' => 'Dokumen create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Dokumen tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Dokumen create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_dokumen)
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
                '__message' => 'Dokumen tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'Dokumen update',
            ], 422);
        }

        // Cek jika ID Dokumen yang diberikan merupakan Integer
        if (!is_numeric($id_dokumen)){
            return response()->json([
                'data' => 'ID Dokumen: ' . $id_dokumen,
                '__message' => 'Dokumen tidak berhasil diperbarui, ID Dokumen harus berupa Integer',
                '__func' => 'Dokumen update',
            ], 422);
        }

        // Cek jika ID Dokumen yang diberikan apakah tersedia di tabel
        if (dokumen::where('id', $id_dokumen)->exists()) {

          {

                 // Eksekusi pembaruan data Dokumen
                 $query = dokumen::where('id', $id_dokumen)->update([
                    'id_ukm' => $request->id_ukm,
                    'nama' => $request->nama,
                    'description' =>$request->description        
                  
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Dokumen berhasil diperbarui',
                    '__func' => 'Dokumen update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Dokumen update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Dokumen: ' . $id_dokumen,
            '__message' => 'Id Dokumen tidak berhasil diperbarui, ID Dokumen tidak ditemukan',
            '__func' => 'Dokumen update',
        ], 500);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_dokumen)
    {
        // Cek jika ID Dokumen yang diberikan merupakan Integer
        if (!is_numeric($id_dokumen)){
            return response()->json([
                'data' => 'ID Dokumen: ' . $id_dokumen,
                '__message' => 'Dokumen tidak berhasil diambil, ID Dokumen harus berupa Integer',
                '__func' => 'Dokumen detail',
            ], 422);
        }

        // Cek jika ID Dokumen yang diberikan apakah tersedia di tabel
        if (dokumen::where('id', $id_dokumen)->exists()) {

            // Eksekusi pembaruan data Dokumen
            $query = dokumen::where('id', $id_dokumen)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Dokumen berhasil diambil',
                    '__func' => 'Dokumen detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Dokumen detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Dokumen ' . $id_dokumen,
            '__message' => 'Dokumen tidak berhasil diambil, ID Dokumen tidak ditemukan',
            '__func' => 'Dokumen detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_dokumen)
    {
        // Cek jika ID Dokumen yang diberikan merupakan Integer
        if (!is_numeric($id_dokumen)){
            return response()->json([
                'data' => 'ID Kategori: ' . $id_dokumen,
                '__message' => 'Dokumen tidak berhasil dihapus, ID Dokumen harus berupa Integer',
                '__func' => 'Dokumen delete',
            ], 422);
        }

        // Cek jika ID Dokumen yang diberikan apakah tersedia di tabel
        if (dokumen::where('id', $id_dokumen)->exists()) {

            // Eksekusi penghapusan data Kategori
            $query = dokumen::where('id', $id_dokumen)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Dokumen berhasil dihapus',
                    '__func' => 'Dokumen delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Dokumen delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Dokumen: ' . $id_dokumen,
            '__message' => 'Dokumen tidak berhasil dihapus, ID Dokumen tidak ditemukan',
            '__func' => 'Dokumen delete',
        ], 500);
    }

}
