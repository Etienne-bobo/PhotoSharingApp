<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
class Liker extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function userlike(){
        return $this->belongsTo(User::class, 'liker_id' , 'id');
    }
}
