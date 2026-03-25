<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StrokeController extends Controller
{
    public function form()
    {
        return view('upload');
    }

    public function processImage(Request $request)
    {
        $image = $request->file('image');

        // Konversi gambar ke file untuk dikirim ke API
        $response = Http::attach(
            'file', 
            file_get_contents($image),
            $image->getClientOriginalName()
        )->post(env('API_URL_BACKEND', 'http://127.0.0.1:8000') . '/predict');

        $result = $response->json();

        return view('upload', compact('result'));
    }
}
