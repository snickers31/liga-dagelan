<?php

use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Klasemen');
});


Route::get('/klasemen', [AdminController::class, 'IndexClub']);
Route::post('/klub', [AdminController::class, 'CreateClub']);
Route::post('/match', [AdminController::class, 'CreateMatch']);
