<?php

namespace App;

use App\Http\Controllers\HelperController;
use Illuminate\Database\Eloquent\Model;
use Cache;
use Config;
use App\ProductOption as ProductOption;
use Validator;

class Product extends Model
{   
    public $errors = '';
    protected $fillable = array('featured', 'title_en', 'title_nb', 'description_en', 'benefits_en', 'benefits_nb' , 'tips_en','tips_nb','description_nb', 'in_stock', 'slug', 'thumbnail', 'tips', 'benefits', 'tags', 'hidden_tags', 'category_id');
    

    public function price(){
        $option = $this->options()->first();
        if(! $option){
            abort('Product price missing', 503);
        }

        return $option->price * HelperController::getRate();
    }


    public function title(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->title_nb : $this->title_en);
    }

    public function description(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->description_nb : $this->description_en);
    }

    public function tips(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->tips_nb : $this->tips_en);
    }

    public function benefits(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->benefits_nb : $this->benefits_en);
    }

    public function orders(){
        return $this->belongsToMany('App\Order', 'order_product')->withPivot('quantity');;
    }

    public function get_option($slug){
        return ProductOption::where('product_id', $this->id)
                            ->where('slug',$slug)
                            ->first();
    }

    // relatinshop helpers
    public function ingredients(){
        return $this->belongsToMany('App\Ingredient', 'ingredient_product');
    }

    public function options(){
        return $this->hasMany('App\ProductOption');
    }

    public function related()
    {
        return $this->belongsToMany('App\Product', 'product_related', 'product_id', 'related_id');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function images(){
        return $this->hasMany('App\Image');
    }

    public function translations(){
        return $this->hasMany('App\ProductTranslation');
    }

    // validations

    private $store_rules = array(
            'category'          => 'required|Integer',

            'title_en'          => 'unique:products,title_en|required|max:1000',
            'title_nb'          => 'unique:products,title_en|required|max:1000',

            'description_en'    => 'required',
            'description_nb'    => 'required',

            'tips_en'           => 'required',
            'tips_nb'           => 'required',

            'benefits_en'       => 'required',
            'benefits_nb'       => 'required',

            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png',
            
            'tags'              => 'required',
    );

    private $update_rules = array(
            'category'          => 'Integer',
            'thumbnail'         => 'max:100000|mimes:jpeg,jpg,png',
    );

    public function validate_store($data){
        $validator = Validator::make($data, $this->store_rules);
        
        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        } 
        return true;
    }

    public function validate_edit($data){
        $validator = Validator::make($data, $this->update_rules);
        
        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        } 
        return true;
    }

}
