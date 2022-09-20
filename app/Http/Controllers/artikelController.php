<?php

namespace App\Http\Controllers;

use App\Models\artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/*
|--------------------------------------------------------------------------
| CRUD Tabel Artikel
|--------------------------------------------------------------------------
|
| artikelController digunakan untuk mengelola tabel artikel. Dapat diakses dalam
| router grup "/artikel".
|
| - LIST - Menampilkan daftar artikel
| - DETAIL - Menampilkan detail data artikel
| - CREATE - Membuat data artikel baru
| - UPDATE - Memperbarui data artikel
| - DELETE - Menghapus data artikel
|
*/


class artikelController extends Controller
{
     /**
     * Get List artikel
     * @OA\Get (
     *     path="/artikel",
     *     tags={"Artikel"},
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
        // Jika tabel artikel gak ada isi maka 
        if (artikel::count() > 0) {
            $data = artikel::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Artikel berhasil diambil',
                '__func' => 'Artikel List',
            ], 200);
        }

        return response()->json([
            'data' => 'Artikel tidak ditemukan',
            '__message' => 'Daftar Artikel berhasil diambil',
            '__func' => 'Artikel List',
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
            // 'id_users' => ['required'],
            'id_ukm' => ['required'],
            'id_artikel_kategori' => ['required',],
            'title' => ['string'],
            'intro' => ['string'],
            'content' => ['string'],
            'foto_artikel' => ['mimes:jpg,png,jpeg'],
            'total_hit' => ['integer'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Artikel tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Artikel create',
            ], 422);
        }

        // Cek jika variabel "$request->foto_artikel" merupakan sebuah file
        if ($request->hasFile('foto_artikel')) {

            // Upload file gambar kedalam folder public dan kembalikan nama file 
            $nama_file = $this->uploadFile($request->foto_artikel);

        }

        // Eksekusi pembuatan data artikel
        $query = artikel::create([
            
            // 'id_users' => $request->id_users,
            'id_ukm' =>  $request->id_ukm,
            'id_artikel_kategori' =>  $request->id_artikel_kategori,
           
            'title' =>  $request->title,
            'intro' =>  $request->intro,
            'content' =>  $request->content,
            'foto_artikel' => $nama_file,
            'total_hit' =>  $request->total_hit
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Artikel berhasil dibuat',
                '__func' => 'Artikel create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Artikel tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Artikel create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_artikel)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
              // 'id_users' => ['required'],
              'id_ukm' => ['required'],
              'id_artikel_kategori' => ['required',],
              'title' => ['string'],
              'intro' => ['string'],
              'content' => ['string'],
              'foto_artikel' => ['mimes:jpg,png,jpeg'],
              'total_hit' => ['integer'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Artikel tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'Artikel update',
            ], 422);
        }

        // Cek jika ID artikel yang diberikan merupakan Integer
        if (!is_numeric($id_artikel)){
            return response()->json([
                'data' => 'ID artikel: ' . $id_artikel,
                '__message' => 'artikel tidak berhasil diperbarui, ID artikel harus berupa Integer',
                '__func' => 'artikel update',
            ], 422);
        }

        // Cek jika ID artikel yang diberikan apakah tersedia di tabel
        if (artikel::where('id', $id_artikel)->exists()) {

            // Cek jika variabel "$request->foto_artikel" merupakan sebuah file
            if ($request->hasFile('foto_artikel')) {

                // Upload file gambar kedalam folder public dan kembalikan nama file 
                $nama_file = $this->uploadFile($request->foto_artikel);

                // Eksekusi pembaruan data artikel
                $query = artikel::where('id', $id_artikel)->update([
                    'id_ukm' =>  $request->id_ukm,
                    'id_artikel_kategori' =>  $request->id_artikel_kategori,
                    'title' =>  $request->title,
                    'intro' =>  $request->intro,
                    'content' =>  $request->content,
                    'foto_artikel' => $nama_file,
                    'total_hit' =>  $request->total_hit
                ]);
            } else {

                 // Eksekusi pembaruan data artikel tanpa "foto artikel"
                 $query = artikel::where('id', $id_artikel)->update([
                    'id_ukm' =>  $request->id_ukm,
                    'id_artikel_kategori' =>  $request->id_artikel_kategori,
                    'title' =>  $request->title,
                    'intro' =>  $request->intro,
                    'content' =>  $request->content,
                    'total_hit' =>  $request->total_hit
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'artikrl berhasil diperbarui',
                    '__func' => 'artikel update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'artikel tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'artikel update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID artikel: ' . $id_artikel,
            '__message' => 'Artikel tidak berhasil diperbarui, ID Artikel tidak ditemukan',
            '__func' => 'Artikel update',
        ], 500);
    }
    

    
       /**
     * Get Detail Artikel
     * @OA\Get (
     *     path="/artikel/{id}",
     *     tags={"Artikel"},
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
    public function detail($id_artikel)
    {
        // Cek jika ID artikel yang diberikan merupakan Integer
        if (!is_numeric($id_artikel)){
            return response()->json([
                'data' => 'ID Artikel: ' . $id_artikel,
                '__message' => 'Artikel tidak berhasil diambil, ID Artikel harus berupa Integer',
                '__func' => 'Artikel detail',
            ], 422);
        }

        // Cek jika ID artikel yang diberikan apakah tersedia di tabel
        if (artikel::where('id', $id_artikel)->exists()) {

            // Eksekusi pembaruan data artikel
            $query = artikel::where('id', $id_artikel)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Artikel berhasil diambil',
                    '__func' => 'Artikel detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Artikel tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Artikel detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Artikel: ' . $id_artikel,
            '__message' => 'Artikel tidak berhasil diambil, ID Artikel tidak ditemukan',
            '__func' => 'Artikel detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_artikel)
    {
        // Cek jika ID artikel yang diberikan merupakan Integer
        if (!is_numeric($id_artikel)){
            return response()->json([
                'data' => 'ID Artikel: ' . $id_artikel,
                '__message' => 'Artikel tidak berhasil dihapus, ID Artikel harus berupa Integer',
                '__func' => 'Artikel delete',
            ], 422);
        }

        // Cek jika ID artikel yang diberikan apakah tersedia di tabel
        if (artikel::where('id', $id_artikel)->exists()) {

            // Eksekusi penghapusan data artikel
            $query = artikel::where('id', $id_artikel)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Artikel berhasil dihapus',
                    '__func' => 'Artikel delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Artikel tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Artikel delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Artikel: ' . $id_artikel,
            '__message' => 'Artikel tidak berhasil dihapus, ID Artikel tidak ditemukan',
            '__func' => 'Artikel delete',
        ], 500);
    }
}
