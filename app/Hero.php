<?php

namespace App;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Config;

class Hero extends Model
{
    protected $fillable = ['title_en', 'title_nb', 'video', 'image'];

    public function title(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->title_nb : $this->title_en);
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
