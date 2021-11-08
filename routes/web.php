<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;
use Laravelista\Comments\CommentController;
use Illuminate\Http\Request;
use App\Models\Image;
use Laravel;
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
    ->get('/image/{id}/edit', [ImageController::class, 'edit'])->name('image.edit');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/image/{id}/edit/comments', function(Request $request,$id){
        $comment = new \Laravelista\Comments\Comment;
        $image = Image::find($id);
        $comment->commenter()->associate(auth()->user());
        $comment->commentable()->associate($image);
        $comment->commentable_id = $image->id;
        $comment->comment = $request->comment;
        $comment->approved = true;
        $comment->save();

        return $comment;
    });


Route::middleware(['auth:sanctum', 'verified'])
    ->get('image/{id}/edit/comments', function($id){
        $image = Image::find($id);
        $comments = $image->comments()->get();
        return $comments;
    });