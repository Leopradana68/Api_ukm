<?php

namespace App\Http\Controllers;

use App\Models\news;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class newsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel artikel gak ada isi maka 
        if (news::count() > 0) {
            $data = news::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar news berhasil diambil',
                '__func' => 'news List',
            ], 200);
        }

        return response()->json([
            'data' => 'news tidak ditemukan',
            '__message' => 'news Artikel berhasil diambil',
            '__func' => 'news List',
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
            'id_news_kategori' => ['required',],
            'title' => ['string'],
            'intro' => ['string'],
            'content' => ['string'],
            'foto_news' => ['mimes:jpg,png,jpeg'],
            'total_hit' => ['integer'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'news tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'news create',
            ], 422);
        }

        // Cek jika variabel "$request->foto_ukm" merupakan sebuah file
        if ($request->hasFile('foto_news')) {

            // Upload file gambar kedalam folder public dan kembalikan nama file 
            $nama_file = $this->uploadFile($request->foto_news);

        }

        // Eksekusi pembuatan data ukm
        $query = news::create([
            
            // 'id_users' => $request->id_users,
            'id_ukm' =>  $request->id_ukm,
            'id_news_kategori' =>  $request->id_news_kategori,
           
            'title' =>  $request->title,
            'intro' =>  $request->intro,
            'content' =>  $request->content,
            'foto_news' => $nama_file,
            'total_hit' =>  $request->total_hit
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'news berhasil dibuat',
                '__func' => 'News create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'News tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'News create',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_news)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
              // 'id_users' => ['required'],
              'id_ukm' => ['required'],
              'id_news_kategori' => ['required',],
              'title' => ['string'],
              'intro' => ['string'],
              'content' => ['string'],
              'foto_news' => ['mimes:jpg,png,jpeg'],
              'total_hit' => ['integer'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'News tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'News update',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_news)){
            return response()->json([
                'data' => 'ID News: ' . $id_news,
                '__message' => 'News tidak berhasil diperbarui, ID artikel harus berupa Integer',
                '__func' => 'News update',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (news::where('id', $id_news)->exists()) {

            // Cek jika variabel "$request->foto_artikel" merupakan sebuah file
            if ($request->hasFile('foto_news')) {

                // Upload file gambar kedalam folder public dan kembalikan nama file 
                $nama_file = $this->uploadFile($request->foto_news);

                // Eksekusi pembaruan data ukm
                $query = news::where('id', $id_news)->update([
                    'id_ukm' =>  $request->id_ukm,
                    'id_news_kategori' =>  $request->id_news_kategori,
                    'title' =>  $request->title,
                    'intro' =>  $request->intro,
                    'content' =>  $request->content,
                    'foto_news' => $nama_file,
                    'total_hit' =>  $request->total_hit
                ]);
            } else {

                 // Eksekusi pembaruan data artikel tanpa "foto artikel"
                 $query = news::where('id', $id_news)->update([
                    'id_ukm' =>  $request->id_ukm,
                    'id_news_kategori' =>  $request->id_news_kategori,
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
                    '__message' => 'News berhasil diperbarui',
                    '__func' => 'News update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'News tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'News update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID News: ' . $id_news,
            '__message' => 'News tidak berhasil diperbarui, ID News tidak ditemukan',
            '__func' => 'News update',
        ], 500);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_news)
    {
        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_news)){
            return response()->json([
                'data' => 'ID News: ' . $id_news,
                '__message' => 'News tidak berhasil diambil, ID News harus berupa Integer',
                '__func' => 'News detail',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (news::where('id', $id_news)->exists()) {

            // Eksekusi pembaruan data ukm
            $query = news::where('id', $id_news)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail News berhasil diambil',
                    '__func' => 'News detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'News tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'News detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID News: ' . $id_news,
            '__message' => 'News tidak berhasil diambil, ID News tidak ditemukan',
            '__func' => 'News detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_news)
    {
        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_news)){
            return response()->json([
                'data' => 'ID News: ' . $id_news,
                '__message' => 'News tidak berhasil dihapus, ID News harus berupa Integer',
                '__func' => 'News delete',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (news::where('id', $id_news)->exists()) {

            // Eksekusi penghapusan data ukm
            $query = news::where('id', $id_news)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'News berhasil dihapus',
                    '__func' => 'News delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'News tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'News delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID News: ' . $id_news,
            '__message' => 'News tidak berhasil dihapus, ID News tidak ditemukan',
            '__func' => 'News delete',
        ], 500);
    }
}
