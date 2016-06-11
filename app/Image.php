<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = array('thumbnail_full', 'thumbnail_medium', 'thumbnail_small', 'description', 'product_id');

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
