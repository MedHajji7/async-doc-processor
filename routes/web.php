<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;





Route::get('/', function () {
    return view('welcome');
});


// Route::post('/documents', [DocumentController::class, 'store']);