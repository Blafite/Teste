<?php

use Illuminate\Support\Facades\Route;
use App\Mail\EnvioEmails;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('envio-email', function(){
    // return new \App\Mail\EnvioEmails();
    Mail::send(new \App\Mail\EnvioEmails());
});