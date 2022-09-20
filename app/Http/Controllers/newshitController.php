<?php

namespace App\Http\Controllers;


use App\Models\news_hit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| CRUD Tabel News_hit
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel News_hit. Dapat diakses dalam
| router grup "/newshit".
|
| - LIST - Menampilkan daftar News_hit
| - DETAIL - Menampilkan detail data News_hit
| - CREATE - Membuat data News_hit baru
| - UPDATE - Memperbarui data News_hit
| - DELETE - Menghapus data News_hit
|
*/

class newshitController extends Controller
{
     /**
     * Get List News Hit
     * @OA\Get (
     *     path="/newshit",
     *     tags={"News Hit"},
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
        // Jika tabel News_hit gak ada isi maka 
        if (news_hit::count() > 0) {
            $data = news_hit::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar news_hit berhasil diambil',
                '__func' => 'news_hit List',
            ], 200);
        }

        return response()->json([
            'data' => 'news_hit tidak ditemukan',
            '__message' => 'Daftar news_hit berhasil diambil',
            '__func' => 'news_hit List',
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
            'id_news' =>['required',],
            'ip' => ['string'],
            'device' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'news_hit tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'news_hit create',
            ], 422);
        }

    

        // Eksekusi pembuatan data News_hit
        $query =news_hit::create([
            'id_news' => $request->id_news,
            'ip' => $request->ip,  
            'device' => $request->device,

        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'news_hit berhasil dibuat',
                '__func' => 'news_hit create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'news_hit tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'news_hit create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_news_hit)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_news' =>['required',],
            'ip' => ['string'],
            'device' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'news_hit tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'news_hit update',
            ], 422);
        }

        // Cek jika ID News_hit yang diberikan merupakan Integer
        if (!is_numeric($id_news_hit)){
            return response()->json([
                'data' => 'ID news_hit: ' . $id_news_hit,
                '__message' => 'news_hit tidak berhasil diperbarui, ID news_hit harus berupa Integer',
                '__func' => 'news_hit update',
            ], 422);
        }

        // Cek jika ID News_hit yang diberikan apakah tersedia di tabel
        if (news_hit::where('id', $id_news_hit)->exists()) {

          {

                 // Eksekusi pembaruan data News_hit
                 $query = news_hit::where('id', $id_news_hit)->update([
                    'id_news' => $request->id_news,
                    'ip' => $request->ip,  
                    'device' => $request->device,
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'news_hit berhasil diperbarui',
                    '__func' => 'news_hit update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'news_hit tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'news_hit update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID news_hit: ' . $id_news_hit,
            '__message' => 'Id news_hit tidak berhasil diperbarui, ID news_hit tidak ditemukan',
            '__func' => 'news_hit update',
        ], 500);
    }
    
    
       /**
     * Get Detail News Hit
     * @OA\Get (
     *     path="/newshit/{id}",
     *     tags={"News Hit"},
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
    public function detail($id_news_hit)
    {
        // Cek jika ID News_hit yang diberikan merupakan Integer
        if (!is_numeric($id_news_hit)){
            return response()->json([
                'data' => 'ID news_hit: ' . $id_news_hit,
                '__message' => 'news_hit tidak berhasil diambil, ID news_hit harus berupa Integer',
                '__func' => 'news_hit detail',
            ], 422);
        }

        // Cek jika ID News_hit yang diberikan apakah tersedia di tabel
        if (news_hit::where('id', $id_news_hit)->exists()) {

            // Eksekusi pembaruan data News_hit
            $query = news_hit::where('id', $id_news_hit)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail news_hit berhasil diambil',
                    '__func' => 'news_hit detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'news_hit tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'news_hit detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID news_hit: ' . $id_news_hit,
            '__message' => 'news_hit tidak berhasil diambil, ID news_hit tidak ditemukan',
            '__func' => 'news_hit detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_news_hit)
    {
        // Cek jika ID News_hit yang diberikan merupakan Integer
        if (!is_numeric($id_news_hit)){
            return response()->json([
                'data' => 'ID news_hit: ' . $id_news_hit,
                '__message' => 'news_hit tidak berhasil dihapus, ID news_hit harus berupa Integer',
                '__func' => 'news_hit delete',
            ], 422);
        }

        // Cek jika ID News_hit yang diberikan apakah tersedia di tabel
        if (news_hit::where('id', $id_news_hit)->exists()) {

            // Eksekusi penghapusan data News_hit
            $query = news_hit::where('id', $id_news_hit)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'news_hit berhasil dihapus',
                    '__func' => 'news_hit delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'news_hit tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'news_hit delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID news_hit: ' . $id_news_hit,
            '__message' => 'news_hit tidak berhasil dihapus, ID news_hit tidak ditemukan',
            '__func' => 'news_hit delete',
        ], 500);
    }
}
