<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\Album;
use App\Models\Image;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums  = Album::where('user_id', auth()->user()->id)->latest()->get();
        return Inertia::render('Album/Index', [
            'albums' => $albums              
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories  = Category::get();
        return Inertia::render('Album/Create', [
            'categories' => $categories              
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$image = $request->file('image')->store('albums');
        $image = $request->file('image')->storeOnCloudinary()->getSecurePath();;
        Album::create([
            'name' => $request->get('name'),
            'slug' => $request->get('name'),
            'description' => $request->get('description'),
            'category_id' => $request->get('category'),
            'user_id' => auth()->user()->id,
            'image' => $image
        ]);
        return Redirect::route('album.index')->with('message', 'Success Album created...');;
        // $id = $album->id;
        // return response()->json(['id' => $id]);
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
    public function edit(Album $album)
    {
        $categories = Category::get();
        return Inertia::render('Album/Edit', [
            'album' => [
                'id' => $album->id,
                'name' => $album->name,
                'description' => $album->description,
                'image' => $album->image,
                'category' => $album->category()->get(),
                'images' => $album->images()->get()->map->only('id', 'image'),
            ],
            'categories' => $categories
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
        $album = Album::find($id);
        $image = $album->image;
        if($request->hasFile('image')){
            $image = $request->file('image')->storeOnCloudinary()->getSecurePath();
            \Storage::delete($album->image);
        }    
        $album->name = $request->get('name');
        $album->description = $request->get('description');
        $album->category_id = $request->get('category');
        $album->image = $image;
        $album->save();
        return redirect()->back()->with('message', 'Success Album updated ....');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        (new Image())->deleteImage($id);
        $album = Album::find($id);
        $album->delete();
        return Redirect::route('album.index')->with('message', 'Success Album deleted ....');
    }


    public function getAlbums(){
        $albums  = Album::where('user_id', auth()->user()->id)->latest()->get();
        return $albums;
    }
}
