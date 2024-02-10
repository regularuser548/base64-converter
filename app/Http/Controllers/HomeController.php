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
            'picture'=>'required'
        ]);

        $picture = $request->file('picture');

        return response()->json(['fileName'=>$picture->getClientOriginalName(), 'base64'=> base64_encode($picture->getContent())]);

    }
}
