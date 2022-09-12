<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| CRUD Tabel UKM
|--------------------------------------------------------------------------
|
| UkmController digunakan untuk mengelola tabel UKM. Dapat diakses dalam
| router grup "/ukm".
|
| - LIST - Menampilkan daftar UKM
| - DETAIL - Menampilkan detail data UKM
| - CREATE - Membuat data UKM baru
| - UPDATE - Memperbarui data UKM
| - DELETE - Menghapus data UKM
|
*/

class UkmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel UKM gak ada isi maka 
        if (Ukm::count() > 0) {
            $data = Ukm::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar UKM berhasil diambil',
                '__func' => 'UKM List',
            ], 200);
        }

        return response()->json([
            'data' => 'Ukm tidak ditemukan',
            '__message' => 'Daftar UKM berhasil diambil',
            '__func' => 'UKM List',
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
            'nama' => ['required', 'string', 'min:3'],
            'jenis' => ['required', 'string'],
            'singkatan_ukm' => ['required', 'string', 'min:1'],
            'foto_ukm' => ['required', 'mimes:jpg,png,jpeg'],
            'keterangan' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'UKM tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'UKM create',
            ], 422);
        }

        // Cek jika variabel "$request->foto_ukm" merupakan sebuah file
        if ($request->hasFile('foto_ukm')) {

            // Upload file gambar kedalam folder public dan kembalikan nama file 
            $nama_file = $this->uploadFile($request->foto_ukm);

        }

        // Eksekusi pembuatan data ukm
        $query = Ukm::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'singkatan_ukm' => $request->singkatan_ukm,
            'foto_ukm' => $nama_file,
            'keterangan' => $request->keterangan
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'UKM berhasil dibuat',
                '__func' => 'UKM create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'UKM tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'UKM create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_ukm)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'nama' => ['string', 'min:3'],
            'jenis' => ['string'],
            'singkatan_ukm' => ['string', 'min:1'],
            'foto_ukm' => ['mimes:jpg,png,jpeg'],
            'keterangan' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'UKM tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'UKM update',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_ukm)){
            return response()->json([
                'data' => 'ID Ukm: ' . $id_ukm,
                '__message' => 'UKM tidak berhasil diperbarui, ID UKM harus berupa Integer',
                '__func' => 'UKM update',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (Ukm::where('id', $id_ukm)->exists()) {

            // Cek jika variabel "$request->foto_ukm" merupakan sebuah file
            if ($request->hasFile('foto_ukm')) {

                // Upload file gambar kedalam folder public dan kembalikan nama file 
                $nama_file = $this->uploadFile($request->foto_ukm);

                // Eksekusi pembaruan data ukm
                $query = Ukm::where('id', $id_ukm)->update([
                    'nama' => $request->nama,
                    'jenis' => $request->jenis,
                    'singkatan_ukm' => $request->singkatan_ukm,
                    'foto_ukm' => $nama_file,
                    'keterangan' => $request->keterangan
                ]);
            } else {

                 // Eksekusi pembaruan data ukm tanpa "foto ketua"
                 $query = Ukm::where('id', $id_ukm)->update([
                    'nama' => $request->nama,
                    'jenis' => $request->jenis,
                    'singkatan_ukm' => $request->singkatan_ukm,
                    'keterangan' => $request->keterangan
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'UKM berhasil diperbarui',
                    '__func' => 'UKM update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'UKM tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'UKM update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Ukm: ' . $id_ukm,
            '__message' => 'UKM tidak berhasil diperbarui, ID UKM tidak ditemukan',
            '__func' => 'UKM update',
        ], 500);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_ukm)
    {
        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_ukm)){
            return response()->json([
                'data' => 'ID Ukm: ' . $id_ukm,
                '__message' => 'UKM tidak berhasil diambil, ID UKM harus berupa Integer',
                '__func' => 'UKM detail',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (Ukm::where('id', $id_ukm)->exists()) {

            // Eksekusi pembaruan data ukm
            $query = Ukm::where('id', $id_ukm)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail UKM berhasil diambil',
                    '__func' => 'UKM detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'UKM tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'UKM detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Ukm: ' . $id_ukm,
            '__message' => 'UKM tidak berhasil diambil, ID UKM tidak ditemukan',
            '__func' => 'UKM detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_ukm)
    {
        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_ukm)){
            return response()->json([
                'data' => 'ID Ukm: ' . $id_ukm,
                '__message' => 'UKM tidak berhasil dihapus, ID UKM harus berupa Integer',
                '__func' => 'UKM delete',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (Ukm::where('id', $id_ukm)->exists()) {

            // Eksekusi penghapusan data ukm
            $query = Ukm::where('id', $id_ukm)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'UKM berhasil dihapus',
                    '__func' => 'UKM delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'UKM tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'UKM delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Ukm: ' . $id_ukm,
            '__message' => 'UKM tidak berhasil dihapus, ID UKM tidak ditemukan',
            '__func' => 'UKM delete',
        ], 500);
    }
}