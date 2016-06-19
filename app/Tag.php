<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = array('title', 'slug');

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
