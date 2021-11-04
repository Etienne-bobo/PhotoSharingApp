<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Album;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function deleteImage($imageId){
        Image::where('album_id', $imageId)->delete();
    }

    public function album(){
        return $this->belongsTo(Album::class);
    }
}
