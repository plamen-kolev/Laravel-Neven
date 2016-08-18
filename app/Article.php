<?php

namespace App;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = array('title', 'thumbnail','body', 'tags', 'slug');

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
