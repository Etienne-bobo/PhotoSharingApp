<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Album;
use App\Models\Image;
use App\Models\User;
use App\Models\Follower;
use App\Models\Liker;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getAlbumsList(){
        $albums  = Album::latest()->take(3)->get();
        $images  = Image::latest()->take(6)->get();
        return Inertia::render('Home/Index', [
            'albums' => $albums ,
            'images' => $images             
        ]);
    }

    // public function getOneAlbum($id){
    //     $oneAlbum = Album::find($id);
    //     return Inertia::render('Home/OneAlbum', [
    //         'oneAlbumPhotos' => $oneAlbum->images()->get() ,
    //         'albumName' => $oneAlbum->name
    //     ]);
    // }

    public function getAllAlbumlist(){
        $allAlbum = Album::latest()->get();
        return Inertia::render('Home/AllAlbum', [
            'allAlbum' => $allAlbum,
        ]);
    }

    public function imageOwnerProfile($id){
        $imageOwnerProfile = User::where('id', $id)->get();
        return $imageOwnerProfile;
    }

    public function userAlbums($id){
        if (User::where('id', '=', $id)->exists()) {
            $userAlbums = Album::where('user_id', $id)->with('user')->get();
            $user = User::find($id);
            if(\Auth::check()){
                $userId = $id;
                $follows = (new User)->amIfollowing($userId);
               }else{
                   $userId = null;
                   $follows = null;
               }
            return Inertia::render('Home/UserAlbums', [
                'userAlbums' => $userAlbums,
                'OneUser' => $user,
                'follows' => $follows,
                'user' => auth()->user(),
            ]);
         }else{
             return Redirect::route('zon');
         }
       
    }

    public function statistics(){
        $albums = Album::where('user_id', auth()->user()->id)->with('images')->get();
        $followings = Follower::where('follower_id', auth()->user()->id)->with('userfollow')->get();
        $followers = Follower::where('following_id', auth()->user()->id)->with('whofollowUser')->get();
        // foreach($followings as $following){
        //     $userId = $following->userfollow();
        // }
        // $follows = (new User)->amIfollowing($userId);
        return Inertia::render('Dashboard', [
            'userAlbums' => $albums,
            'followings' => $followings,
            'followers' => $followers,
        ]);
    }
}
