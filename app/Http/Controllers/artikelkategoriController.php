<?php

namespace App\Http\Controllers;

use App\Models\artikel_kategori;
use Illuminate\Http\Request;

class artikelkategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = artikel_kategori::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua artikel kategori',
            'data' => $data
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(([
            'id_ukm' => 'required|max:191',
            'nama_kategori'=> 'required|max:191',
         
           

         
        ]));

        $artikel_kategori = new artikel_kategori();
        $artikel_kategori->id_ukm= $request->get('id_ukm');
        $artikel_kategori->nama_kategori = $request->get('nama_kategori');
        $artikel_kategori = $artikel_kategori->save();
        if ($artikel_kategori) {
            return response()->json([
                'status' => '200',
                'student' => "artikel kategori berhasil di simpan !"
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'student' => "artikel kategori gagal di simpan !"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        {
            $artikel_kategori = artikel_kategori::find($id);
            // $student = Student::select('id', 'name', 'course', 'email', 'phone')->get();
            if ($artikel_kategori) {
                return  response()->json([
                    'status' => '200',
                    'artikel_kategori' => $artikel_kategori
                ]);
            } else {
                return response()->json([
                    'status' => '404',
                    'artikel_kategori' => "Data Not Found....."
                ]);
            }
           
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(([
            'id_ukm' => 'required|max:191',
            'nama_kategori'=> 'required|max:191',
        ]));

        $artikel_kategori = new artikel_kategori();
        $artikel_kategori->id_ukm= $request->get('id_ukm');
        $artikel_kategori->nama_kategori = $request->get('nama_kategori');
        $artikel_kategori = $artikel_kategori->save();
  
        if ($artikel_kategori) {
            return response()->json([
                'status' => '200',
                'student' => "Data Updated Sucessfully..."
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'student' => "error in updating data..."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        {
            $artikel_kategori = artikel_kategori::find($id);
            if ($artikel_kategori) {
                $artikel_kategori->delete();
                return  response()->json([
                    'status' => '200',
                    'artikel_kategori' => "Data Deleted Successfully....."
                ]);
            } else {
                return response()->json([
                    'status' => '404',
                    'artikel_kategori' => "Data Not Found....."
                ]);
            }
        }
    }
}