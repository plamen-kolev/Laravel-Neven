<?php

namespace App\Http\Controllers;
use App\Hero as Hero;
use View;
use Illuminate\Http\Request;
use Storage;
use File;
use App\Http\Requests;

class HeroController extends Controller
{
    public function index(){
        $objects = Hero::all();
        $data = [
            'objects' => $objects
        ];
        return View::make('hero.index')->with($data);
    }

    public function show($slug){
        $paginate_count = (int) env('PAGINATION');
        $category = Category::where('slug', $slug)->first();
        $products = Product::where('category_id', $category->id)->orderBy("created_at", 'desc')->paginate($paginate_count);
        $data = array(
            'products'  => $products,
            'title'     =>  $category->title(),
            'page_title'    => trans($category->title())
        );
        return View::make('product.index')->with($data);
    }

    public function create(){
        $object = new Hero;

        $data = array(
            'object'  => $object,
            'method' => 'post',
            'route' => 'hero.store'
        );
        return View::make('hero.create_or_edit')->with($data);
    }

    public function store(Request $request){
        $object = new Hero();
        $this->validate($request, [
            // 'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime, video/ogv, video/ogg, video/mp4 | max:100000',
            'video' => 'mimes:mp4,mov,ogg,ogv,webm,mp4 | max:50000|required',
            'title_en' => 'required',
            'title_nb' => 'required',
        ]);

        $filename = HelperController::upload_image($request->file('video'), 'videos');
        $filepath = public_path("videos/$filename");
        File::move(public_path("media/videos/$filename"), $filepath);

        if($request->file('image')){
            $imagename = HelperController::upload_image($request->file('image'), 'videos/thumbnails/');
            $object->image = $imagename;
            File::move(public_path("media/videos/thumbnails/$imagename"), public_path("videos/thumbnails/$imagename"));
        }

        $object->video = $filename;
        $object->title_en = $request->get('title_en');
        $object->title_nb = $request->get('title_nb');
        $object->save();
        return redirect()->route('hero.index');
    }

    public function edit($id){
        $object = Hero::where('id', $id)->first();
        if (!$object){
            return abort(404, "Hero $object not found");
        };
        $data = array(
            'object'   => $object,
            'method' => 'put',
            'route' => 'hero.update'
        );
        return View::make('hero.create_or_edit')->with($data);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            // 'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime, video/ogv, video/ogg, video/mp4 | max:100000',
            'video' => 'mimes:mp4,mov,ogg,ogv,webm,mp4 | max:50000',
        ]);

        $object = Hero::where('id', $id)->first();
        $object->update( $request->all() );

        if($request->file('image') && $request->file('image')->isValid()){
            $imagename = HelperController::upload_image($request->file('image'), 'videos/thumbnails/');
            $object->image = $imagename;
            File::move(public_path("media/videos/thumbnails/$imagename"), public_path("videos/thumbnails/$imagename"));
        }

        if($request->file('video') && $request->file('video')->isValid()){
            $filename = HelperController::upload_image($request->file('video'), 'videos');
            $filepath = public_path("videos/$filename");
            File::move(public_path("media/videos/$filename"), $filepath);
        }

        $object->save();
        return redirect()->route('hero.index');
    }

    public function destroy($id){
        Hero::where('id', $id)->first()->delete();
        return back();
    }
}
