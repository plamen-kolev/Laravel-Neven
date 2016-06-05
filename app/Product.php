<?php

namespace App;

use App\Http\Controllers\HelperController;
use Illuminate\Database\Eloquent\Model;
use Cache;
use App\ProductOption as ProductOption;
use Validator;

class Product extends Model
{   
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['title', 'description', 'tips', 'benefits'];
    protected $fillable = array('featured', 'title', 'in_stock', 'slug', 'description', 'thumbnail_full', 'thumbnail_small', 'thumbnail_medium', 'tips', 'benefits', 'tags', 'hidden_tags');
    public $errors = '';
    public function price(){
        $option = $this->options()->first();
        if(! $option){
            abort('Product price missing', 503);
        }

        return $option->price * HelperController::getRate();
    }
    
    // public function getCachedTranslation($language){
    //     $key = 'translation' + $this->id;
    //     if(Cache::has($key)){
    //         return Cache::get($key);
    //     }
    //     print "not cached";
    //     $translation = $this->translations()->where('locale', $language)->first();
    //     Cache::put($key, $translation, env('CACHE_TIMEOUT', 60));
    //     return $translation;
    // }

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
            'title_en'          => 'unique:product_translations,title|required|max:1000',
            'title_nb'          => 'unique:product_translations,title|required|max:1000',

            'description_en'    => 'required',
            'description_nb'    => 'required',

            'tips_en'           => 'required',
            'tips_nb'           => 'required',

            'benefits_en'       => 'required',
            'benefits_nb'       => 'required',

            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png',
            'category'          => 'required|Integer',
            'tags'              => 'required',
    );

    public function validate_store($data){
        $validator = Validator::make($data, $this->store_rules);
        
        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        } 
        return true;
    }

}
