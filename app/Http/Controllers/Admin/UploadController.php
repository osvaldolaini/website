<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $name = uniqid(). '_' . trim($file->getClientOriginalName());
        if($file->storeAs('public/tmp', $name)){
            return response()->json([
                'name'=> $name,
                'path' => url('storage/tmp'),
                'status'=>'success'
            ]);
        }else{
            return response()->json([
                'name'=> $name,
                'status'=>'error'
            ]);
        }
    }
}
