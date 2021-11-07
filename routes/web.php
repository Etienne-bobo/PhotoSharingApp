<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->resource('album', AlbumController::class);


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/getAlbums', [AlbumController::class, 'getAlbums']);


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/image/create/{albumId}', [ImageController::class, 'create'])->name('image.create');


Route::middleware(['auth:sanctum', 'verified'])
    ->post('/image/store', [ImageController::class, 'store']);

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/image/edit/{id}', [ImageController::class, 'edit'])->name('image.edit');