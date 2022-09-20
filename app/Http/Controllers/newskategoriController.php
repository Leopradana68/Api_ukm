<?php

namespace App\Http\Controllers;

use App\Models\news_kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
/*
|--------------------------------------------------------------------------
| CRUD Tabel News kategori
|--------------------------------------------------------------------------
|
| ArtikelkategoriController digunakan untuk mengelola tabel news_kategori. Dapat diakses dalam
| router grup "/newskategori".
|
| - LIST - Menampilkan daftar news_kategori
| - DETAIL - Menampilkan detail data news_kategori
| - CREATE - Membuat data news_kategori baru
| - UPDATE - Memperbarui data news_kategori
| - DELETE - Menghapus data news_kategori
|
*/

class newskategoriController extends Controller
{
     /**
     * Get List News Kategori
     * @OA\Get (
     *     path="/newskategori",
     *     tags={"News Kategori"},
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
        // Jika tabel news_kategori gak ada isi maka 
        if (news_kategori::count() > 0) {
            $data = news_kategori::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar news kategori berhasil diambil',
                '__func' => 'News kategori List',
            ], 200);
        }

        return response()->json([
            'data' => 'News kategori tidak ditemukan',
            '__message' => 'Daftar News kategori berhasil diambil',
            '__func' => 'News kategori List',
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

    

        // Eksekusi pembuatan data news_kategori
        $query = news_kategori::create([
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
                '__message' => 'news_kategori tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'news_kategori update',
            ], 422);
        }

        // Cek jika ID news_kategori  yang diberikan merupakan Integer
        if (!is_numeric($id_kategori)){
            return response()->json([
                'data' => 'ID Kategori: ' . $id_kategori,
                '__message' => 'news_kategori tidak berhasil diperbarui, ID KATEGORI harus berupa Integer',
                '__func' => 'news_kategori update',
            ], 422);
        }

        // Cek jika ID news_kategori yang diberikan apakah tersedia di tabel
        if (news_kategori::where('id', $id_kategori)->exists()) {

          {

                 // Eksekusi pembaruan data kategori 
                 $query = news_kategori::where('id', $id_kategori)->update([
                    'id_ukm' => $request->id_ukm,
                    'nama_kategori' => $request->nama_kategori,
                  
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'news_kategori berhasil diperbarui',
                    '__func' => 'news_kategori update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'news_kategori tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'news_kategori update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Kategori: ' . $id_kategori,
            '__message' => 'Id Kategori tidak berhasil diperbarui, ID kategoti tidak ditemukan',
            '__func' => 'news_kategori update',
        ], 500);
    }
    
       /**
     * Get Detail News Kategori
     * @OA\Get (
     *     path="/newskategori/{id}",
     *     tags={"News Kategori"},
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
        if (news_kategori::where('id', $id_kategori)->exists()) {

            // Eksekusi pembaruan data kategori
            $query = news_kategori::where('id', $id_kategori)->first();
    
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
            '__message' => 'Kategori tidak berhasil diambil, ID kategori tidak ditemukan',
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
        if (news_kategori::where('id', $id_kategori)->exists()) {

            // Eksekusi penghapusan data Kategori
            $query = news_kategori::where('id', $id_kategori)->delete();
    
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
