<?php
namespace App\Http\Controllers;

use App\User;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use App\Product as Product;
use App\Category as Category;
use App\Ingredient as Ingredient;
use App\Slide as Slide;
use App\Image as Image;
use App\Tag as Tag;
use App\Review as Review;
use App\Article as Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaravelLocalization;
use Illuminate\Support\Str as Str;
use App\ProductOption as ProductOption;
use App\ShippingOption as ShippingOption;
class FakerController extends Controller
{
    protected $category_num = 5;
    protected $ingredient_num = 10;
    protected $product_num = 60;
    protected $ingredients_per_product = 3;
    protected $related_images = 10;
    protected $tags = 5;
    protected $slide_images = 5;
    protected $articles = 20;
    protected $options = 3;
    protected $reviews = 3;

    protected $languages = [
        'norwegian' => 'nb',
        'english'   => 'en'
    ];



    public function init($product_num=60, $category_num=5){
        $this->get_or_create_test_user( env('SELENIUM_TEST_USER') );
        $this->product_num = $product_num;
        $this->category_num = $category_num;

        $languages = array_keys(LaravelLocalization::getSupportedLocales());
        $faker = Faker::create();

        # create articles
        foreach(range(1,$this->articles) as $index){
            $title = $faker->word;
            Article::create([
                'title' => $title,
                'slug'  => Str::slug($title),
                'tags'  => "$faker->word, $faker->word, $faker->word, $faker->word",
                'body'  => $faker->text,
            ]);
        }

        foreach(range(1,$this->slide_images) as $index){
            Slide::create([
                'image' => $faker->imageUrl($width = 1560, $height = 480),
                'url'   => "google.com",
                'description' => $faker->text
            ]);
        }

        foreach(range(1,$this->category_num) as $index){
            // CATEGORY
            $title = 'Category' . $index  . str_random(10);
            $category = new Category ([
                'thumbnail_full'    => $faker->imageUrl($width = 1280, $height = 720),
                'thumbnail_medium'  => $faker->imageUrl($width = 640, $height = 480),
                'thumbnail_small'   => $faker->imageUrl($width = 150, $height = 70),
                'slug'      =>  Str::slug($title)
            ]);
            $category->save();
            // CATEGORY LOCALIZATION
            $category->translateOrNew($this->languages['english'])->title = "{$title}";
            $category->translateOrNew($this->languages['english'])->description = "descr {$faker->text}";

            $category->translateOrNew($this->languages['norwegian'])->title = "Norwegian {$title}";
            $category->translateOrNew($this->languages['norwegian'])->description = "Norwegian {$faker->text}";

            $category->save();

        }

        // INGREDIENT
        foreach(range(1,$this->ingredient_num) as $index){
            $title = 'Ingredient' . $index  . str_random(10);
            $ingredient = Ingredient::create([
                'thumbnail_full'    => $faker->imageUrl($width = 1280, $height = 720),
                'thumbnail_medium'  => $faker->imageUrl($width = 640, $height = 480),
                'thumbnail_small'   => $faker->imageUrl($width = 150, $height = 70),
                'slug'       =>  Str::slug($title)
            ]);
            $ingredient->save();
            // INGREDIENT LOCALIZATION

            $ingredient->translateOrNew($this->languages['english'])->title = "{$title}";
            $ingredient->translateOrNew($this->languages['english'])->description = "{$faker->text}";

            $ingredient->translateOrNew($this->languages['norwegian'])->title = "Norwegian {$title}";
            $ingredient->translateOrNew($this->languages['norwegian'])->description = "Norwegian {$faker->text}";

            $ingredient->save();

        }

        // Create product
        foreach(range(1,$this->product_num) as $index){
            $category = Category::find($faker->numberBetween($min = 1, $max = $this->category_num));

            // Add products
            $title = "Title{$faker->word} en " . str_random(10);
            $product = new Product([
                'thumbnail_full'    => $faker->imageUrl($width = 1280, $height = 720),
                'thumbnail_medium'  => $faker->imageUrl($width = 640, $height = 480),
                'thumbnail_small'   => $faker->imageUrl($width = 150, $height = 150),
                'in_stock'  => $faker->boolean(50),
                'featured'  => $faker->boolean(10),
                'slug'      => Str::slug($title)
                
            ]);

            // ADD Category
            $product->category()->associate($category);
            $product->save();

            // reviews
            foreach(range(1,$this->reviews) as $index){
                $review = new Review([
                    'body'      => $faker->text,
                    'rating'    => rand (1, 5)
                ]);

                $review->user()->associate(User::find(1));
                $review->product()->associate($product);
                $review->save();
            }
            

            // Options
            foreach(range(1,$this->options) as $index){
                $option = new ProductOption([
                    'title'  => $faker->word,
                    'price'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 100),
                    'weight' => 50
                ]);
                $option->slug = Str::slug($option->title);
                $option->product_id = $product->id;
                $option->save();

            }
            // add product language texsts


            $product->translateOrNew($this->languages['english'])->title = $title;
            $product->translateOrNew($this->languages['english'])->description = "descr {$faker->text}";
            $product->translateOrNew($this->languages['english'])->tips = "tip {$faker->text}";
            $product->translateOrNew($this->languages['english'])->benefits = "benefit {$faker->text}";

            $product->translateOrNew($this->languages['norwegian'])->title = "Norwegian {$title}";
            $product->translateOrNew($this->languages['norwegian'])->description = "Norwegian descr {$faker->text}";
            $product->translateOrNew($this->languages['norwegian'])->tips = "Norwegian tip {$faker->text}";
            $product->translateOrNew($this->languages['norwegian'])->benefits = "Norwegian benefit {$faker->text}";

            $product->save();

            // ADD related images
            foreach(range(1, $this->related_images) as $index){
                $image = new Image([
                    'thumbnail_full'    => $faker->imageUrl($width = 1280, $height = 720),
                    'thumbnail_medium'  => $faker->imageUrl($width = 640, $height = 480),
                    'thumbnail_small'   => $faker->imageUrl($width = 150, $height = 150),
                ]);

                $image->product()->associate($product);
                $image->save();
            }
            // Add tags
            foreach(range(1, $this->tags) as $index){
                $title = 'Tag ' . $index . $product  . str_random(10);
                $tag = new Tag();
                $tag->title = $title;
                $tag->slug = Str::slug($title);

                $tag->product()->associate($product);
                $tag->save();
            }

            // Add ingredients
            foreach(range(1, $this->ingredients_per_product) as $index){
                $product->ingredients()
                    ->attach(Ingredient::find(
                        $faker->numberBetween($min=1, $max=$this->ingredient_num)
                    )
                    );
            }
        }

        // associate products
        foreach(Product::all() as $product){
            $product->related()->attach(Product::find(1)->first());
            $product->related()->attach($product);
            $product->save();
        }

        // fake articles for the blog
        foreach(range(1, $this->articles) as $index){
            new Article([
                'tag' => $faker->word  . str_random(10),
                'body'=> $faker->text  . str_random(10),
                'tags'=> $faker->word . str_random(10),
            ]);
        }

        // create shipping options
        ShippingOption::create([
            'country_code' => 'NO',
            'weight'       => 300,
            'price'        => 10
        ]);

        ShippingOption::create([
            'country_code' => 'NO',
            'weight'       => 500,
            'price'        => 30
        ]);

        ShippingOption::create([
            'country_code' => 'GB',
            'weight'       => 300,
            'price'        => 30
        ]);


        ShippingOption::create([
            'country_code' => 'ALL',
            'weight'       => 300,
            'price'        => 300
        ]);

        return 1;
    }

    public static function get_or_create_test_user($name){
        if($user = User::where('name', $name)->first()){
            return $user;
        } else {
            $user = User::create([
                'name'      => $name,
                'email'     => $name . '@neven.com',
                'active'    => 1,
                // bcrypt hash for password
                'password'  => '$2a$10$AqQvOKVP0yHsGr/HnBAwueyna5J8skzTeNEXYYTdxD7RPWv99SHaG'
            ]);
            return $user;
        }
    }

}
