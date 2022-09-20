<?php

namespace App\Http\Controllers;


use App\Models\video_item_galleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/*
|--------------------------------------------------------------------------
| CRUD Tabel video_item_galleri
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel video_item_galleri. Dapat diakses dalam
| router grup "/videoitemgalleri".
|
| - LIST - Menampilkan daftar  video_item_galleri
| - DETAIL - Menampilkan detail data  video_item_galleri
| - CREATE - Membuat data  video_item_galleri baru
| - UPDATE - Memperbarui data  video_item_galleri
| - DELETE - Menghapus data  video_item_galleri
*/


class videoitemgalleriController extends Controller
{
     /**
     * Get List Video Item
     * @OA\Get (
     *     path="/videoitemgalleri",
     *     tags={"Video Item"},
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
        // Jika tabel  video_item_galleri gak ada isi maka 
        if (video_item_galleri::count() > 0) {
            $data = video_item_galleri::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Video berhasil diambil',
                '__func' => 'Video List',
            ], 200);
        }

        return response()->json([
            'data' => 'Video tidak ditemukan',
            '__message' => 'Video berhasil diambil',
            '__func' => 'Video List',
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
            'video_url' => ['string'],
            'tumbnail_url' => ['string'],
            
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Video tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Video create',
            ], 422);
        }


        // Eksekusi pembuatan data  video_item_galleri
        $query = video_item_galleri::create([
            'id_galleri' => $request->id_galleri,
            'video_url' => $request->video_url,
            'tumbnail_url' => $request->tumbnail_url,
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Video berhasil dibuat',
                '__func' => 'Video create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Video tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Video create',
        ], 500);
    }
    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_video)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_galleri' => ['required'],
            'video_url' => ['string'],
            'tumbnail_url' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'video tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'video update',
            ], 422);
        }

        // Cek jika ID  video_item_galleri yang diberikan merupakan Integer
        if (!is_numeric($id_video)){
            return response()->json([
                'data' => 'ID Video: ' . $id_video,
                '__message' => 'video tidak berhasil diperbarui, ID video harus berupa Integer',
                '__func' => 'Video update',
            ], 422);
        }

        // Cek jika ID  video_item_galleri yang diberikan apakah tersedia di tabel
        if (video_item_galleri::where('id', $id_video)->exists()) {

          {

                 // Eksekusi pembaruan data  video_item_galleri
                 $query = video_item_galleri::where('id', $id_video)->update([
                    'id_galleri' => $request->id_galleri,
                    'video_url' => $request->video_url,
                     'tumbnail_url' => $request->tumbnail_url,
                  
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Video berhasil diperbarui',
                    '__func' => 'Video update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Video update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video: ' . $id_video,
            '__message' => 'Id Video tidak berhasil diperbarui, ID Video tidak ditemukan',
            '__func' => 'Video update',
        ], 500);
    }
    
    
       /**
     * Get Detail Video Item
     * @OA\Get (
     *     path="/videoitemgalleri/{id}",
     *     tags={"Video Item"},
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
    public function detail($id_video)
    {
        // Cek jika ID  video_item_galleri yang diberikan merupakan Integer
        if (!is_numeric($id_video)){
            return response()->json([
                'data' => 'ID Video: ' . $id_video,
                '__message' => 'Video tidak berhasil diambil, ID Video harus berupa Integer',
                '__func' => 'Video detail',
            ], 422);
        }

        // Cek jika ID  video_item_galleri  yang diberikan apakah tersedia di tabel
        if (video_item_galleri::where('id', $id_video)->exists()) {

            // Eksekusi pembaruan data  video_item_galleri
            $query =video_item_galleri::where('id', $id_video)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Video berhasil diambil',
                    '__func' => 'Video detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Video detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video: ' . $id_video,
            '__message' => 'Video tidak berhasil diambil, ID Video tidak ditemukan',
            '__func' => 'Video detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_video)
    {
        // Cek jika ID  video_item_galleri yang diberikan merupakan Integer
        if (!is_numeric($id_video)){
            return response()->json([
                'data' => 'ID Video: ' . $id_video,
                '__message' => 'Video tidak berhasil dihapus, ID Video harus berupa Integer',
                '__func' => 'Video delete',
            ], 422);
        }

        // Cek jika ID  video_item_galleri yang diberikan apakah tersedia di tabel
        if (video_item_galleri::where('id', $id_video)->exists()) {

            // Eksekusi penghapusan data  video_item_galleri
            $query = video_item_galleri::where('id', $id_video)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Video berhasil dihapus',
                    '__func' => 'Video delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Video delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video: ' . $id_video,
            '__message' => 'Video tidak berhasil dihapus, ID Video tidak ditemukan',
            '__func' => 'Video delete',
        ], 500);
    }
    
}
