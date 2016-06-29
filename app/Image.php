<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = array('thumbnail', 'description', 'product_id');

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
