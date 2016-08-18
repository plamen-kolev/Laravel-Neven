<?php

namespace App;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
