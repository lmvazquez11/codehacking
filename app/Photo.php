<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    protected $fillable = ['file'];

    //---Directory definition
    protected $uploads = '/images/';

    //---Accesor
    public function getFileAttribute($photo){
        return $this->uploads. $photo;
    }


}
