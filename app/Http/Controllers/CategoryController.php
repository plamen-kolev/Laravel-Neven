<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Http\Requests;
use App\Category as Category;
use View;
use DB;
use App\Http\Controllers\HelperController as HelperController ;

class CategoryController extends Controller
{
    public function show($slug){
        $paginate_count = (int) env('PAGINATION');
        $category = Category::where('slug', $slug)->first();
        $products = $category->products()->paginate($paginate_count);

        $data = array(
            'products'  => $products,
            'title'     => "Category " . $category->title()
        );
//      == END ==
        return View::make('product.index')->with($data);
    }

    public function create(){
        $category = new Category;
        
        $data = array(
            'category'  => $category
        );
        return View::make('category.create')->with($data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title_en'          => 'unique:category_translations,title|required|max:255',
            'title_nb'          => 'unique:category_translations,title|required|max:255',
            'description_en'    => 'required|max:255',
            'description_nb'    => 'required|max:255',
            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png'
        ]);    

        if ($request->file('thumbnail')->isValid()) {
            $data = array(
                'alert_type'    => 'alert-success',
                'alert_text'    => 'Category created successfully',
                'message'       => 'Creation successful'
            );

            $paths = HelperController::crop_image(
                $request->file('thumbnail'), 
                'categories', 
                $request->input('title_en'), 
                array(env('MEDIUM_THUMBNAIL'), 
                env('SMALL_THUMBNAIL'))
            );
            
            $category = new Category([
                'thumbnail_full'    => $paths[0],
                'thumbnail_medium'  => $paths[1],
                'thumbnail_small'   => $paths[2],
                'slug'      =>  Str::slug($request->get('title_en'))
            ]);

            $category->save();
            
            $category->translateOrNew('en')->title          = $request->get('title_en');
            $category->translateOrNew('en')->description    = $request->get('description_en');

            $category->translateOrNew('nb')->title          = $request->get('title_nb');
            $category->translateOrNew('nb')->description    = $request->get('description_nb');

            $category->save();
            
            return View::make('message')->with($data);
        }

        return Response('File upload failed', 400);
    }

    public function edit($slug){
        $category = Category::where('slug', $slug)->first();

        if (!$category){
            return abort(404, "Category $slug not found");
        };

        $data = array(
            'category'   => $category,
            'en_translation'    => CategoryTranslation::where('category_id', $category->id)
                                                    ->where('locale','en')
                                                    ->first(),
            'nb_translation'    => CategoryTranslation::where('category_id', $category->id)
                                                    ->where('locale','en')
                                                    ->first(),
        );

        return View::make('category.edit')->with($data);
    }

    public function destroy($slug){
        $category = Category::where('slug', $slug)->first();
        if (!$category){
            return abort(404, "Category $slug not found");
        };
        $category->delete();

        $data = array(
            'alert_type'    => 'alert-success',
            'alert_text'    => 'Product added successful',
            'message'       => 'Deleting ' . $category->title . ' successful'
        );

        return View::make('message')->with($data);
    }
}
