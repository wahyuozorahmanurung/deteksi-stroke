<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StrokeController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [StrokeController::class, 'form']);
Route::post('/process', [StrokeController::class, 'processImage'])->name('process.image');
Route::get('/', function () {
    return view('landingpage');
});
Route::get('/upload', function () {
    return view('upload');
})->name('upload.page');
