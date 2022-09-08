<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class menuController extends Controller
{ 
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
    

    public function allmenu()
{
   $menu = menu::with(str_repeat('children.',100))->whereNull('parent_id')->get();
    // $menu = menu::whereNull('parent_id',0)->with(str_repeat('children',10))->get();
      
   return response()->json($menu, 200);
} 

}
