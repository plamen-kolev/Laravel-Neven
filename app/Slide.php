<?php

namespace App;
use Config;
use Illuminate\Database\Eloquent\Model;
use Cache;
class Slide extends Model
{
    protected $fillable = array('image','url', 'description_en', 'description_nb');

    public function description(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->description_nb : $this->description_en);
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
