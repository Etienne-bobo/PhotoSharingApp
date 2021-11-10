<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FollowController;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Config;

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

Route::get('/', [HomeController::class, 'getAlbumsList'])->name('zon');
// Route::get('/onealbum/{id}', [HomeController::class, 'getOneAlbum'])->name('one.album');
Route::get('/allalbum', [HomeController::class, 'getAllAlbumlist'])->name('all.album');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('album', AlbumController::class);


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/getAlbums', [AlbumController::class, 'getAlbums']);

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/image/delete/{id}', [ImageController::class, 'destroy']);

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/image/create/{albumId}', [ImageController::class, 'create'])->name('image.create');


Route::middleware(['auth:sanctum', 'verified'])
    ->post('/image/store', [ImageController::class, 'store']);

Route::get('/image/{id}/edit', [ImageController::class, 'edit'])->name('image.edit');

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
    ->post('/image/{id}/edit/comment/{commentId}/reply', function(Request $request,$id, $commentId){
        $comment = new \Laravelista\Comments\Comment;
        $com = $comment->find($commentId);
        $image = Image::find($id);
        $commentClass = Config::get('comments.model');
        $reply = new $commentClass;
        $reply->commenter()->associate(auth()->user());
        $reply->commentable()->associate($image);
        $reply->parent()->associate($com);
        $reply->commentable_id = $commentId;
        $reply->comment = $request->reply;
        $reply->approved = true;
        $reply->save();

        return $reply;
    });


Route::get('image/{id}/edit/comments', function($id){
        $image = Image::find($id);
        $comments = $image->comments()->get();
        return $comments;
});

Route::get('/imageOwnerProfile/{id}', [HomeController::class, 'imageOwnerProfile']);

Route::get('/userAlbums/{id}', [HomeController::class, 'userAlbums'])->name('user.albums');

// following

Route::post('/follow', [FollowController::class, 'followUnfollow']);

