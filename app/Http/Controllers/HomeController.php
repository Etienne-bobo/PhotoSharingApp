<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Album;
use App\Models\Image;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getAlbumsList(){
        $albums  = Album::latest()->take(3)->get();
        $images  = Image::latest()->take(3)->get();
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
}
