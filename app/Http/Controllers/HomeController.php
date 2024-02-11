<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function encodeImageAjax(Request $request)
    {
        $request->validate([
            'picture'=>'required|image|max:1000'
        ]);

        $picture = $request->file('picture');

        $base64 = base64_encode($picture->getContent());

        return response()->json(['fileName'=>$picture->getClientOriginalName(),
            'fileSizeBytes'=>$picture->getSize(),
            'base64'=> $base64,
            'encodedFileSizeBytes' => strlen($base64)]);

    }
}
