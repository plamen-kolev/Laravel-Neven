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
            'page_title'    => $article->title
        ];

        return View::make('article.show')->with($data);
    }

    public function create(){
        $data = [
            'article' => new Article(),
            'method' => 'post',
            'route'  => 'blog.store'
        ];

        return View::make('article.create_or_edit')->with($data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title'             => 'unique:articles|required|max:1000',
            'body'              => 'required',
            'tags'              => 'required',

        ]);
        $article = new Article([
            'slug'      => Str::slug($request->get('title')),
            'title'     => $request->get('title'),
            'body'      => $request->get('body'),
            'tags'      => $request->get('tags'),
        ]);

        if($request->file('thumbnail') && $request->file('thumbnail')->isValid()){
            $article->thumbnail = HelperController::upload_image($request->file('thumbnail'));
        }

        $article->save();

        // now send email to every subscriber
        $subscribers = DB::table('subscribers')->select('email')->get();

        foreach ($subscribers as $subscriber) {
            EmailController::send_article( ['article' => $article], $subscriber);
        }
        return redirect()->route('blog.show', $article->slug);
    }

    public function destroy($slug){
        $article = Article::where('slug', $slug)->first();
        if (!$article){
            return abort(404, "Article $slug not found");
        };
        $article->delete();
        return redirect()->route('blog.index');
    }

    public function edit($slug){
        $article = Article::where('slug', $slug)->first();
        if (!$article){
            return abort(404, "Article $slug not found");
        };
        $data = array(
            'article'   => $article,
            'route' => 'blog.update',
            'method'    => 'put'
        );
        return View::make('article.create_or_edit')->with($data);
    }

    public function update(Request $request, $slug){
        $article = Article::where('slug', $slug)->first();
        $article->update( $request->all() );
        $article->slug = Str::slug($request->get('title'));
        if($request->file('thumbnail') && $request->file('thumbnail')->isValid()){
            $article->thumbnail = HelperController::upload_image($request->file('thumbnail'));
        }
        $article->save();
        
        return redirect()->route('blog.show', $article->slug);
    }
}
