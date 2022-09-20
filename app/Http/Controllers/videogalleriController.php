<?php

namespace App\Http\Controllers;

use App\Models\video_galleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/*
|--------------------------------------------------------------------------
| CRUD Tabel video galleri
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel video galleri. Dapat diakses dalam
| router grup "/videogalleri".
|
| - LIST - Menampilkan daftar video galleri
| - DETAIL - Menampilkan detail data video galleri
| - CREATE - Membuat data video galleri baru
| - UPDATE - Memperbarui data video galleri
| - DELETE - Menghapus data video galleri
|
*/

class videogalleriController extends Controller
{ /**
    * Get List Video Galleri
    * @OA\Get (
    *     path="/videogalleri",
    *     tags={"Video Galleri"},
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
        // Jika tabel video galleri gak ada isi maka 
        if (video_galleri::count() > 0) {
            $data =video_galleri::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Video Galleri berhasil diambil',
                '__func' => 'Video Galleri List',
            ], 200);
        }

        return response()->json([
            'data' => 'Video Galleri tidak ditemukan',
            '__message' => 'Daftar Video Galleri berhasil diambil',
            '__func' => 'Video Galleri List',
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
                '__message' => 'Video Galleri tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Video Galleri create',
            ], 422);
        }

    

        // Eksekusi pembuatan data video galleri
        $query = video_galleri::create([
            'id_ukm' => $request->id_ukm,
            'nama' => $request->nama,
            'description' =>$request->description

        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Video Galleri berhasil dibuat',
                '__func' => 'Video Galleri create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Video Galleri tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Video Galleri create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_video_galleri)
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
                '__message' => 'Video Galleri tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'Video Galleri  update',
            ], 422);
        }

        // Cek jika ID video galleri yang diberikan merupakan Integer
        if (!is_numeric($id_video_galleri)){
            return response()->json([
                'data' => 'ID Video Galleri: ' . $id_video_galleri,
                '__message' => 'Video Galleri tidak berhasil diperbarui, ID Video Galleri harus berupa Integer',
                '__func' => 'Video Galleri update',
            ], 422);
        }

        // Cek jika ID video galleri yang diberikan apakah tersedia di tabel
        if (video_galleri::where('id', $id_video_galleri)->exists()) {

          {

                 // Eksekusi pembaruan data video galleri
                 $query = video_galleri::where('id', $id_video_galleri)->update([
                    'id_ukm' => $request->id_ukm,
                    'nama' => $request->nama,
                    'description' =>$request->description        
                  
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Video Galleri berhasil diperbarui',
                    '__func' => 'Video Galleri update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video Galleri tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Video Galleri update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video Galleri: ' . $id_video_galleri,
            '__message' => 'Id Video galleri tidak berhasil diperbarui, ID Video Galleri tidak ditemukan',
            '__func' => 'Video Galleri update',
        ], 500);
    }

    
       /**
     * Get Detail Video Galleri
     * @OA\Get (
     *     path="/videogalleri/{id}",
     *     tags={"Video Galleri"},
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
    public function detail($id_video_galleri)
    {
        // Cek jika ID video galleri yang diberikan merupakan Integer
        if (!is_numeric($id_video_galleri)){
            return response()->json([
                'data' => 'ID video Galleri: ' . $id_video_galleri,
                '__message' => 'Video Galleri tidak berhasil diambil, ID Video Galleri harus berupa Integer',
                '__func' => 'Video Galleri detail',
            ], 422);
        }

        // Cek jika ID video galleri yang diberikan apakah tersedia di tabel
        if (video_galleri::where('id', $id_video_galleri)->exists()) {

            // Eksekusi pembaruan data video galleri
            $query = video_galleri::where('id', $id_video_galleri)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Video Galleri berhasil diambil',
                    '__func' => 'Video Galleri detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video Galleri tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Video Galleri detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video Galleri' . $id_video_galleri,
            '__message' => 'video Galleri tidak berhasil diambil, ID Video Galleri tidak ditemukan',
            '__func' => 'Video Galleri detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_video_galleri)
    {
        // Cek jika ID video galleri yang diberikan merupakan Integer
        if (!is_numeric($id_video_galleri)){
            return response()->json([
                'data' => 'ID video Galleri: ' . $id_video_galleri,
                '__message' => 'Video Galleri tidak berhasil dihapus, ID Video Galleri harus berupa Integer',
                '__func' => 'Video Galleri delete',
            ], 422);
        }

        // Cek jika ID video galleri yang diberikan apakah tersedia di tabel
        if (video_galleri::where('id', $id_video_galleri)->exists()) {

            // Eksekusi penghapusan data video galleri
            $query = video_galleri::where('id', $id_video_galleri)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Video Galleri berhasil dihapus',
                    '__func' => 'Video Galleri delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video Galleri tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Video Galleri delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video Galleri : ' . $id_video_galleri,
            '__message' => 'Video Galleri tidak berhasil dihapus, ID Video Galleri tidak ditemukan',
            '__func' => 'Video Galleri delete',
        ], 500);
    }
}
