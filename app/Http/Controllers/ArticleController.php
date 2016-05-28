<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str as Str;
use Illuminate\Http\Request;
use App\Article as Article;
use App\Http\Requests;
use View;

class ArticleController extends Controller
{
    public function index(){
        $data = [
            'articles' => Article::paginate( env('PAGINATION') )
        ];
        return View::make('article.index')->with($data);
    }

    public function show($slug){
        $data = [
            'articles' => Article::where('slug', $slug)->paginate( env('PAGINATION') )
        ];

        return View::make('article.index')->with($data);
    }

    public function create(){
        $data = [
            'article' => new Article()
        ];

        return View::make('article.create')->with($data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title'             => 'unique:articles|required|max:1000',
            'body'              => 'required',
            'tags'              => 'required',

        ]);

        $article = new Article([
            'slug'              => Str::slug($request->get('title')),
            'title'     => $request->get('title'), 
            'body'      => $request->get('body'),
            'tags'   => $request->get('tags'),
        ]);

        $article->save();

        $data = array(
            'alert_type'    => 'alert-success',
            'alert_text'    => 'Article added successful',
            'message'       => 'Creation successful'
        );

        return View::make('message')->with($data);
    }

    public function destroy($slug){
        
    }
}
