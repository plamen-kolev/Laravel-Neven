<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str as Str;
use Illuminate\Http\Request;
use App\Article as Article;
use App\Http\Requests;
use View;
use DB;

class ArticleController extends Controller
{
    public function index(){
        $data = [
            'articles' => DB::table('articles')->orderBy('created_at', 'desc')->paginate( env('PAGINATION') ),
            'page_title'    => trans('text.blog_title')
        ];

        return View::make('article.index')->with($data);
    }



    public function show($slug){
        $article = Article::where('slug', $slug)->first();

        $data = [
            'article' => $article,
            'page_title'    => ' - ' . $article->title
        ];

        return View::make('article.show')->with($data);
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
        $article = Article::where('slug', $slug)->first();
        if (!$article){
            return abort(404, "Article $slug not found");
        };
        $article->delete();

        // $data = array(
        //     // 'alert_text'    => 'Article added successful',
        //     'message'       => 'Deleting ' . $article->title . ' successful'
        // );
        return back();
        // return View::make('message')->with($data);
    }

    public function edit($slug){
        $article = Article::where('slug', $slug)->first();
        if (!$article){
            return abort(404, "Article $slug not found");
        };
        $data = array(
            'article'   => $article
        );
        return View::make('article.edit')->with($data);

    }
}
