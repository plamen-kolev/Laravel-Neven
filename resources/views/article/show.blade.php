@extends('master_page')
@section('content')
<div class="col-md-12">
    <div class="wrapper blog_wrap">
        <div class="col-md-1"></div>
        <div class="col-md-10 row">
            <div class="">
                <div class="article_image_container pull-left">
                    <img class="b-lazy " data-src="{{route('image', $article->thumbnail)}}?w=720&fit=crop" src="{{ asset('images/loading.gif') }}" alt="{{ $article->title}}">    
                </div>
                

                @if(Auth::user() && Auth::user()->admin)
                    {{ Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $article->slug]]) }}
                        {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                    {{ Form::close() }}

                    <a href="{{route('blog.edit', $article->slug)}}">Edit</a>
                @endif
                <h1><a href="{{ route('blog.show', $article->slug) }}">{{ $article->title}}</a></h1>

                <p>{!! str_limit($article->body, $limit = 120, $end = '...') !!}</p>
                <p>{{$article->updated_at}}</p>
                <p>{{$article->tags}}</p>
            </div>
        </div>
        <div class="col-md-1"></div>

    </div>
</div>

@stop
