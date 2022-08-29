<?php

namespace App\Http\Controllers;

use App\Models\ukm;
use Illuminate\Http\Request;


class ukmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
         $data = ukm::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Ukm',
            'data' => $data
        ],200);
    
        // $data = ukm ::all();
        // return response()->json($data);


        // dd ('halo controller');
   
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Recquest $request)
    {
        ukm::create($request->all());
        return response()->json(' Data sudah di masukan' );
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
            'nama_ukm' => 'required|max:191',
            'jenis'=> 'required|max:191',
            'singkatan_ukm'=> 'required|max:191',
            'nama_ketua'=> 'required|max:191',
            'nama_wakil_ketua'=> 'required|max:191',
            'nama_sekertaris'=> 'required|max:191',
            'keterangan' => 'required|max:191',
           

         
        ]));

        $ukm = new ukm();
        $ukm->nama_ukm= $request->get('nama_ukm');
        $ukm->jenis = $request->get('jenis');
        $ukm->singkatan_ukm = $request->get('singkatan_ukm');
        $ukm->nama_ketua= $request->get('nama_ketua');
        $ukm->nama_wakil_ketua= $request->get('nama_wakil_ketua');
        $ukm->nama_sekertaris= $request->get('nama_sekertaris');
        $ukm->keterangan= $request->get('keterangan');
        $ukm = $ukm->save();
        if ($ukm) {
            return response()->json([
                'status' => '200',
                'student' => "ukm berhasil di simpan !"
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'student' => "ukm gagal di simpan !"
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
        $ukm = ukm::find($id);
        // $student = Student::select('id', 'name', 'course', 'email', 'phone')->get();
        if ($ukm) {
            return  response()->json([
                'status' => '200',
                'student' => $ukm
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'student' => "Data Not Found....."
            ]);
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
            'nama_ukm' => 'required|max:191',
            'jenis'=> 'required|max:191',
            'singkatan_ukm'=> 'required|max:191',
            'nama_ketua'=> 'required|max:191',
            'nama_wakil_ketua'=> 'required|max:191',
            'nama_sekertaris'=> 'required|max:191',
            'keterangan' => 'required|max:191',
        ]));

        $ukm = ukm::find($id);
        $ukm->nama_ukm= $request->get('nama_ukm');
        $ukm->jenis = $request->get('jenis');
        $ukm->singkatan_ukm = $request->get('singkatan_ukm');
        $ukm->nama_ketua= $request->get('nama_ketua');
        $ukm->nama_wakil_ketua= $request->get('nama_wakil_ketua');
        $ukm->nama_sekertaris= $request->get('nama_sekertaris');
        $ukm->keterangan= $request->get('keterangan');
        $ukm = $ukm->save();
        if ($ukm) {
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
            $ukm = ukm::find($id);
            if ($ukm) {
                $ukm->delete();
                return  response()->json([
                    'status' => '200',
                    'student' => "Data Deleted Successfully....."
                ]);
            } else {
                return response()->json([
                    'status' => '404',
                    'student' => "Data Not Found....."
                ]);
            }
        }
    }
}
