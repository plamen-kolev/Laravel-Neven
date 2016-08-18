<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Subscriber extends Model
{
    protected $fillable = array('email');

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
