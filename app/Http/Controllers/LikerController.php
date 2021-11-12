<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;
use App\Models\Liker;

class LikerController extends Controller
{
    
    public function likeUnlike(Request $request){
        $likerId = User::find(auth()->user()->id);
        $imageId = Image::find($request->imageId);
        $likerId->liking()->toggle($imageId);
        return redirect()->back();
    }

    public function likeCount($id){
        $likeCount = Liker::where('image_id', $id)->count();
        return $likeCount;
    }

    public function userWhoLike($id){
        $liker = Liker::where('image_id', $id)->with('userlike')->get();
        return $liker;
    }

    public function likeStatus($id){
        if(\Auth::check()){    
            $likes = (new Image)->amIliking($id);
        }else{
            $likes = null;
        }
        return $likes;
    }

}
