<?php

namespace App\Http\Controllers;

use App\Models\artikel_hit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| CRUD Tabel Artikel_hit
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel Artikel_hit. Dapat diakses dalam
| router grup "/artikelhit".
|
| - LIST - Menampilkan daftar Artikel_hit
| - DETAIL - Menampilkan detail Artikel_hit
| - CREATE - Membuat data Artikel_hit baru
| - UPDATE - Memperbarui data Artikel_hit
| - DELETE - Menghapus data Artikel_hit
|
*/

class artikelhitController extends Controller
{ 
      /**
     * Get List artikel_hit
     * @OA\Get (
     *     path="/artikelhit",
     *     tags={"Artikel Hit"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nama",
     *                         type="string",
     *                         example="example nama"
     *                     ),
     *                     @OA\Property(
     *                         property="jenis",
     *                         type="enum",
     *                         example="example jenis"
     *                     ),
     *                     @OA\Property(
     *                         property="singkatan_ukm",
     *                         type="string",
     *                         example="example singkatan_ukm"
     *                     ),
      *                      @OA\Property(
     *                         property="foto_ukm",
     *                         type="text",
     *                         example="example foto_ukm"
     *                     ),          
     *                      @OA\Property(
     *                         property="keterangan",
     *                         type="string",
     *                         example="example keterangan"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */


    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel Artikel_hit gak ada isi maka 
        if (artikel_hit::count() > 0) {
            $data = artikel_hit::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Artikel_hit berhasil diambil',
                '__func' => 'Artikel_hit List',
            ], 200);
        }

        return response()->json([
            'data' => 'Artikel_hit tidak ditemukan',
            '__message' => 'Daftar Artikel_hit berhasil diambil',
            '__func' => 'Artikel_hit List',
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
            'id_artikel' =>['required',],
            'ip' => ['string'],
            'device' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'artikel_hit tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'artikel_hit create',
            ], 422);
        }

    

        // Eksekusi pembuatan data Artikel_hit
        $query = artikel_hit::create([
            'id_artikel' => $request->id_artikel,
            'ip' => $request->ip,  
            'device' => $request->device,

        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'artikel_hit berhasil dibuat',
                '__func' => 'artikel_hit create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'artikel_hit tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'artikel_hit create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_artikel_hit)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_artikel' =>['required',],
            'ip' => ['string'],
            'device' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'artikel_hit tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'artikel_hit update',
            ], 422);
        }

        // Cek jika ID Artikel_hit yang diberikan merupakan Integer
        if (!is_numeric($id_artikel_hit)){
            return response()->json([
                'data' => 'ID artikel_hit: ' . $id_artikel_hit,
                '__message' => 'artikel_hit tidak berhasil diperbarui, ID artikel_hit harus berupa Integer',
                '__func' => 'artikel_hit update',
            ], 422);
        }

        // Cek jika ID Artikel_hit yang diberikan apakah tersedia di tabel
        if (artikel_hit::where('id', $id_artikel_hit)->exists()) {

          {

                 // Eksekusi pembaruan data 
                 $query = artikel_hit::where('id', $id_artikel_hit)->update([
                    'id_artikel' => $request->id_artikel,
                    'ip' => $request->ip,  
                    'device' => $request->device,
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Artikel_hit berhasil diperbarui',
                    '__func' => 'Artikel_hit update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'artikel_hit tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Artikel_hit update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID artikel_hit: ' . $id_artikel_hit,
            '__message' => 'Id artikel_hit tidak berhasil diperbarui, ID artikel_hit tidak ditemukan',
            '__func' => 'Artikel_hit update',
        ], 500);
    }
    

    
       /**
     * Get Detail Artikel_hit
     * @OA\Get (
     *     path="/artikelhit/{id}",
     *     tags={"Artikel Hit"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nama",
     *                         type="string",
     *                         example="example nama"
     *                     ),
     *                     @OA\Property(
     *                         property="jenis",
     *                         type="enum",
     *                         example="example jenis"
     *                     ),
     *                     @OA\Property(
     *                         property="singkatan_ukm",
     *                         type="string",
     *                         example="example singkatan_ukm"
     *                     ),
      *                      @OA\Property(
     *                         property="foto_ukm",
     *                         type="text",
     *                         example="example foto_ukm"
     *                     ),          
     *                      @OA\Property(
     *                         property="keterangan",
     *                         type="string",
     *                         example="example keterangan"
     *                     ),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *         )
     *     )
     * )
     */



    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_artikel_hit)
    {
        // Cek jika ID Artikel_hit yang diberikan merupakan Integer
        if (!is_numeric($id_artikel_hit)){
            return response()->json([
                'data' => 'ID artikel_hit: ' . $id_artikel_hit,
                '__message' => 'Artikel_hit tidak berhasil diambil, ID artikel_hit harus berupa Integer',
                '__func' => 'artikel_hit detail',
            ], 422);
        }

        // Cek jika ID Artikel_hit yang diberikan apakah tersedia di tabel
        if (artikel_hit::where('id', $id_artikel_hit)->exists()) {

            // Eksekusi pembaruan data kategori
            $query = artikel_hit::where('id', $id_artikel_hit)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail artikel_hit berhasil diambil',
                    '__func' => 'artikel_hit detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'artikel_hit tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'artikel_hit detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID artikel_hit: ' . $id_artikel_hit,
            '__message' => 'artikel_hit tidak berhasil diambil, ID artikel_hit tidak ditemukan',
            '__func' => 'artikel_hit detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_artikel_hit)
    {
        // Cek jika ID Artikel_hit yang diberikan merupakan Integer
        if (!is_numeric($id_artikel_hit)){
            return response()->json([
                'data' => 'ID artikel_hit: ' . $id_artikel_hit,
                '__message' => 'artikel_hit tidak berhasil dihapus, ID artikel_hit harus berupa Integer',
                '__func' => 'artikel_hit delete',
            ], 422);
        }

        // Cek jika ID Artikel_hit yang diberikan apakah tersedia di tabel
        if (artikel_hit::where('id', $id_artikel_hit)->exists()) {

            // Eksekusi penghapusan data Kategori
            $query = artikel_hit::where('id', $id_artikel_hit)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'artikel_hit berhasil dihapus',
                    '__func' => 'artikel_hit delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'artikel_hit tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'artikel_hit delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID artikel_hit: ' . $id_artikel_hit,
            '__message' => 'Kategori tidak berhasil dihapus, ID artikel_hit tidak ditemukan',
            '__func' => 'artikel_hit delete',
        ], 500);
    }
}
