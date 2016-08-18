<?php

namespace App;
use App\Product;
use Config;
use Validator;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $errors = '';
    protected $fillable = array('title_en', 'title_nb', 'slug','description_en', 'description_nb', 'thumbnail');


    private $store_rules = array(
            'title_en'          => 'unique:categories,title_en|required|max:255',
            'title_nb'          => 'unique:categories,title_nb|required|max:255',
            'description_en'    => 'required|max:255',
            'description_nb'    => 'required|max:255',
            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png'
    );

    public function validate_store($data){
        $validator = Validator::make($data, $this->store_rules);

        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function title(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->title_nb : $this->title_en);
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
