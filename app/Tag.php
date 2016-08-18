<?php

namespace App;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = array('title', 'slug');

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
