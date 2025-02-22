<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ContactController::class, 'index']); 
Route::resource('contacts', ContactController::class);
Route::post('/contacts/import-xml', [ContactController::class, 'importXML'])->name('contacts.importXML');
