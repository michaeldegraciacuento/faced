<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pdf-form/{id}', [PDFController::class, 'generatePDF'])->name('household.pdf-form');
