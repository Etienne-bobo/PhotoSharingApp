<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Image; 
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function followUnfollow(Request $request){
        $followerId = User::find(auth()->user()->id);
        $followingId = User::find($request->userId);
        $followerId->following()->toggle($followingId);
        return redirect()->back();
    }

    public function followStatus($id){
        $image = Image::find($id);
        if(\Auth::check()){
            $userId = $image->album()->first()->user_id;
            $follows = (new User)->amIfollowing($userId);
    
        }else{
            $follows = null;
        }
        return $follows;
    }
}
