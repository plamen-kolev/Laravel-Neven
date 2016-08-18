<?php

namespace App;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = array('thumbnail', 'description', 'product_id');

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
