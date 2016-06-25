@extends('master_page')
@section('content')
<div class="col-md-12">
    <div class="wrapper blog_wrap">
        <div class="col-md-1"></div>
        <div class="col-md-10 row">
            <div class="">
                <img class="width_100" data-src="{{route('image', $article->thumbnail)}}?w=220&h=150&fit=crop" src="{{ asset('images/loading.gif') }}" alt="{{ $article->title}}">

                @if(Auth::user() && Auth::user()->admin)
                    {!! Form::model($article, array('route' => array('blog.destroy', $article->slug), 'method'=>'delete'  )) !!}
                        {!! Form::submit('delete', array('class' => '') )!!}
                    {!! Form::close() !!}

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
