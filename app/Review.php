<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
class Review extends Model
{
    protected $fillable = array('body', 'rating');

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }

}
