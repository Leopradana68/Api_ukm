<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class menuController extends Controller
{ 
 /**
     * Get List Menu
     * @OA\Get (
     *     path="/menu",
     *     tags={"Menu"},
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
        if (menu::count() > 0) {
            $data = menu::with(str_repeat('children.',100))->whereNull('parent_id')->get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Menu berhasil diambil',
                '__func' => 'Menu List',
            ], 200);
        }

        return response()->json([
            'data' => 'Menu tidak ditemukan',
            '__message' => 'Daftar Menu berhasil diambil',
            '__func' => 'Menu List',
        ], 200);
    }
     /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        // $menu = new menu;

        // $menu->nama = $request->name;
        // $menu->url = $request->url;
        // $menu->parent_id = $request->parent_id; 
        // $menu->hint = $request->hint;
    
        // $category->save(); 
    
        // return response()->json($category, 200);

        // Validiasi data yang diberikan oleh frontend
            $validator = Validator::make($request->all(), [
              'nama' => ['required', 'string', 'min:3'],
              'url' => ['string'],
              'parent_id' => ['integer'],
              'hint' => ['string'],


        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Kategori tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Kategori create',
            ], 422);
        }

    

        // Eksekusi pembuatan data artikel_kategori
        $query = menu ::create([
            'nama' => $request->nama,
            'url' => $request->url,
            'parent_id' => $request->parent_id,
            'hint' => $request->hint,

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
    public function update(Request $request, $id_menu)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'min:3'],
              'url' => ['string'],
              'parent_id' => ['integer'],
              'hint' => ['string'],

        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'menu tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'menu update',
            ], 422);
        }

        // Cek jika ID Artikel_hit yang diberikan merupakan Integer
        if (!is_numeric($id_menu)){
            return response()->json([
                'data' => 'ID menu: ' . $id_menu,
                '__message' => 'menu tidak berhasil diperbarui, ID menu harus berupa Integer',
                '__func' => 'menu update',
            ], 422);
        }

        // Cek jika ID Artikel_hit yang diberikan apakah tersedia di tabel
        if (menu::where('id', $id_menu)->exists()) {

          {

                 // Eksekusi pembaruan data 
                 $query = menu::where('id', $id_menu)->update([
                    'nama' => $request->nama,
                    'url' => $request->url,
                    // 'parent_id' => $request->parent_id,
                    'hint' => $request->hint,
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Menu berhasil diperbarui',
                    '__func' => 'Menu update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Menu tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Menu update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Menu: ' . $id_menu,
            '__message' => 'Id Menu tidak berhasil diperbarui, ID Menu tidak ditemukan',
            '__func' => 'Menu update',
        ], 500);
    }

    
       /**
     * Get Detail Menu
     * @OA\Get (
     *     path="/menu/{id}",
     *     tags={"Menu"},
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
    public function detail($id_menu)
    {
        // Cek jika ID Menu yang diberikan merupakan Integer
        if (!is_numeric($id_menu)){
            return response()->json([
                'data' => 'ID Menu: ' . $id_menu,
                '__message' => 'Menu tidak berhasil diambil, ID Menu harus berupa Integer',
                '__func' => 'Menu detail',
            ], 422);
        }

        // Cek jika ID Menu yang diberikan apakah tersedia di tabel
        if (menu::where('id', $id_menu)->exists()) {

            // Eksekusi pembaruan data artikel
            $query = menu::where('id', $id_menu)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Menu berhasil diambil',
                    '__func' => 'Menu detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Menu tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Menu detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Menu: ' . $id_menu,
            '__message' => 'Menu tidak berhasil diambil, ID Menu tidak ditemukan',
            '__func' => 'Menu detail',
        ], 500);
    }

     /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_menu)
    {
        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_menu)){
            return response()->json([
                'data' => 'ID Menu: ' . $id_menu,
                '__message' => 'Menu tidak berhasil dihapus, ID Menu harus berupa Integer',
                '__func' => 'Menu delete',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (menu::where('id', $id_menu)->exists()) {

            // Eksekusi penghapusan data ukm
            $query = menu::where('id', $id_menu)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Menu berhasil dihapus',
                    '__func' => 'Menu delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Menu tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Menu delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Menu: ' . $id_menu,
            '__message' => 'Menu tidak berhasil dihapus, ID Menu tidak ditemukan',
            '__func' => 'Menu delete',
        ], 500);
    }




//     public function allmenu()
// {
//    $menu = menu::with(str_repeat('children.',100))->whereNull('parent_id')->get();
//     // $menu = menu::whereNull('parent_id',0)->with(str_repeat('children',10))->get();
      
//    return response()->json($menu, 200);
// } 

}
