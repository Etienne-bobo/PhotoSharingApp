<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Album;
use Laravelista\Comments\Commentable;
use App\Models\User;

class Image extends Model
{
    use HasFactory;
    use Commentable;
    
    protected $guarded = [];

    public function deleteImage($imageId){
        Image::where('album_id', $imageId)->delete();
    }

    public function album(){
        return $this->belongsTo(Album::class);
    }

    public function amIliking($imageId){
        return \DB::table('likers')->where('liker_id', auth()->user()->id)
        ->where('image_id', $imageId)->exists();
    }
}
