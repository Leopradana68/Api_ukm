<?php

namespace App\Http\Controllers;

use App\Models\dokumen_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



/*
|--------------------------------------------------------------------------
| CRUD Tabel Dokumen_item
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel dokumen_item. Dapat diakses dalam
| router grup "/dokumenitem".

| - LIST - Menampilkan daftar Dokumen_item
| - DETAIL - Menampilkan detail data  Dokumen_item
| - CREATE - Membuat data  Dokumen_item baru
| - UPDATE - Memperbarui data  Dokumen_item
| - DELETE - Menghapus data  Dokumen_item
|
*/

class dokumenitemController extends Controller
{/*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel dokumen_item gak ada isi maka 
        if (dokumen_item::count() > 0) {
            $data = dokumen_item::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar dokumen item berhasil diambil',
                '__func' => 'Dokumen Item List',
            ], 200);
        }

        return response()->json([
            'data' => 'Dokumen Item tidak ditemukan',
            '__message' => 'Daftar Dokumen Item tidak berhasil diambil',
            '__func' => 'Dokumen item List',
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
            'id_dokumen' => ['required'],
            'foto_ukm' => ['mimes:pdf'],
  
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Dokumen Item tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Dokumen Item create',
            ], 422);
        }

        // Cek jika variabel "$request->dokumen" merupakan sebuah file
        if ($request->hasFile('dokumen')) {

            // Upload file dokumen kedalam folder public dan kembalikan nama file 
            $nama_file = $this->uploadFile($request->dokumen);

        }

        // Eksekusi pembuatan data  Dokumen_item
        $query = dokumen_item::create([
            'id_dokumen' => $request->id_dokumen,
            'dokumen' => $nama_file,
        
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen Item berhasil dibuat',
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
    public function update(Request $request, $id_dokumenitem)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_dokumen' => ['required'],
            'foto_ukm' => ['mimes:pdf'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Dokumen Item tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'Dokumen Item update',
            ], 422);
        }

        // Cek jika ID  Dokumen_item yang diberikan merupakan Integer
        if (!is_numeric($id_dokumenitem)){
            return response()->json([
                'data' => 'ID Dokumen Item: ' . $id_dokumenitem,
                '__message' => 'Dokumen Item tidak berhasil diperbarui, ID Dokumen Item harus berupa Integer',
                '__func' => 'Dokumen Item update',
            ], 422);
        }

        // Cek jika ID  Dokumen_item yang diberikan apakah tersedia di tabel
        if (dokumen_item::where('id', $id_dokumenitem)->exists()) {

            // Cek jika variabel "$request->dokumen " merupakan sebuah file
            if ($request->hasFile('dokumen')) {

                // Upload file dokumen kedalam folder public dan kembalikan nama file 
                $nama_file = $this->uploadFile($request->dokumen);

                // Eksekusi pembaruan data  Dokumen_item
                $query = dokumen_item::where('id', $id_dokumenitem)->update([
                    'id_dokumen' => $request->id_dokumen,
                    'dokumen' => $nama_file,
                ]);
            } else {

                 // Eksekusi pembaruan data  Dokumen_item tanpa file
                 $query = dokumen_item::where('id', $id_dokumenitem)->update([
                    'id_dokumen' => $request->id_dokumen,
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Dokumen Item berhasil diperbarui',
                    '__func' => 'Dokumen Item update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen Item tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Dokumen Item update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Dokumen Item: ' . $id_dokumenitem,
            '__message' => 'Dokumen Item tidak berhasil diperbarui, ID Dokumen Item tidak ditemukan',
            '__func' => 'Dokumen Item update',
        ], 500);
    }
    

     
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_dokumenitem)
    {
        // Cek jika ID  Dokumen_item yang diberikan merupakan Integer
        if (!is_numeric($id_dokumenitem)){
            return response()->json([
                'data' => 'ID Dokumen_Item: ' . $id_dokumenitem,
                '__message' => 'Dokumen Item tidak berhasil diambil, ID Dokumen Item harus berupa Integer',
                '__func' => 'Dokumen Item detail',
            ], 422);
        }

        // Cek jika ID  Dokumen_item yang diberikan apakah tersedia di tabel
        if (dokumen_item::where('id', $id_dokumenitem)->exists()) {

            // Eksekusi pembaruan data  Dokumen_item
            $query = dokumen_item::where('id', $id_dokumenitem)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail dokumen item berhasil diambil',
                    '__func' => 'Dokumen item detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen item tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Dokumen item detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Dokumen item: ' . $id_dokumenitem,
            '__message' => 'Dokumen item tidak berhasil diambil, ID Dokumen item tidak ditemukan',
            '__func' => 'Dokumen Item detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_dokumenitem)
    {
        // Cek jika ID  Dokumen_item yang diberikan merupakan Integer
        if (!is_numeric($id_dokumenitem)){
            return response()->json([
                'data' => 'ID Dokumen Item: ' . $id_dokumenitem,
                '__message' => 'Dokumen Item tidak berhasil dihapus, ID Dokumen Item harus berupa Integer',
                '__func' => 'Dokumen Item delete',
            ], 422);
        }

        // Cek jika ID  Dokumen_item yang diberikan apakah tersedia di tabel
        if (dokumen_item::where('id', $id_dokumenitem)->exists()) {

            // Eksekusi penghapusan data  Dokumen_item
            $query = dokumen_item::where('id', $id_dokumenitem)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Dokumen Item berhasil dihapus',
                    '__func' => 'Dokumen Item delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Dokumen Item tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Dokumen Item delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Dokumen Item: ' . $id_dokumenitem,
            '__message' => 'Dokumen Item tidak berhasil dihapus, ID Dokumen item tidak ditemukan',
            '__func' => 'Dokumen Item delete',
        ], 500);
    }

}
