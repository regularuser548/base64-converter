<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function encodeImageAjax(Request $request)
    {
        $request->validate([
            'picture' => 'required'
        ]);

        $validator = Validator::make($request->all(), [
            'picture' => 'image|max:1000'
        ]);

        $picture = $request->file('picture');

        if ($validator->fails()) {
            return response()->json(['fileName' => $picture->getClientOriginalName(),
            'fileSizeBytes' => $picture->getSize(), 'errors' => $validator->errors()], 412);
        }


        $base64 = base64_encode($picture->getContent());

        return response()->json(['fileName'=>$picture->getClientOriginalName(),
            'fileMimeType' => $picture->getMimeType(),
            'fileSizeBytes'=>$picture->getSize(),
            'base64'=> $base64,
            'encodedFileSizeBytes' => strlen($base64)]);

    }
}
