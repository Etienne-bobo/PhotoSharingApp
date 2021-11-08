<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($albumId)
    {
        $albumBelongsToUser = Album::where('user_id', auth()->user()->id)->where('id', $albumId)->exists();
        //$categories  = Category::get();
        if($albumBelongsToUser){
            $album_id = $albumId;
            return Inertia::render('Image/Create', ['album_id' => $album_id]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->file('images') as $image){
            $imageUrl = $image->storeOnCloudinary()->getSecurePath();

            $image = new Image;
            $image->album_id = $request->album_id;
            $image->image = $imageUrl;
            $image -> save();

            return Redirect::route('album.edit', $image->album_id )->with('message', 'Success Image uploaded...');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::find($id);
        return Inertia::render('Image/Edit', [
            'image' => $image,
            'comments' => $image->comments()->get(),
            'user' => auth()->user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
