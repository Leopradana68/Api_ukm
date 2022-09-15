<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(
*      version="1.0.0",
*      title="Dokumentasi API",
*      description="API UKM Politeknik Negeri Lampung",
*      @OA\Contact(
*          email="leopradana013gmail.com"
*      ),
*      @OA\License(
*          name="Apache 2.0",
*          url="http://www.apache.org/licenses/LICENSE-2.0.html"
*      )
* )
*
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="Demo API Server"
* )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadFile($value)
    {
        $file = $value;
        $nama_file = preg_replace('/\s+/', '', time()."_".$file->getClientOriginalName());
        $tujuan_upload = public_path('/assets/images/data');
        $file->move($tujuan_upload, $nama_file);
        return '/assets/images/data/'.$nama_file;
    }

    // public function uploadDokumen($value)
    // {
    //     $file = $value;
    //     $nama_dokumen = preg_replace('/\s+/', '', time()."_".$file->getClientOriginalName());
    //     $tujuan_upload = public_path('/assets/Dokumen/data');
    //     $file->move($tujuan_upload, $nama_dokumen);
    //     return '/assets/Dokumen/data/'.$nama_dokumen;
    // }
}
