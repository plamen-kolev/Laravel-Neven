@extends('master_page')
@section('content')
<div class="col-md-12">
    <div class="wrapper blog_wrap">

        @foreach ($articles->chunk(4) as $chunk)
        <div class="col-md-12 row">
            @foreach ($chunk as $article)
                <div class="col-md-3 article_thumbnail">
                    <div class="article_wrapper">
                        @if($article->thumbnail)
                            <img class="b-lazy" data-src="{{route('image', $article->thumbnail)}}?w=220&h=150&fit=crop" src="{{ asset('images/loading.gif') }}" alt="{{ $article->title}}">
                        @endif

                        <h1><a href="{{ route('blog.show', $article->slug) }}">{{ $article->title}}</a></h1>

                        <p>{!! str_limit($article->body, $limit = 120, $end = '...') !!}</p>
                        <p>{{$article->updated_at}}
                        @if(Auth::user() && Auth::user()->admin)
                            <span class="pull-right">
                                {{ Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $article->slug]]) }}
                                    {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                                {{ Form::close() }}
                                <a class="glyphicon glyphicon-pencil success" href="{{route('blog.edit', $article->slug)}}"></a>
                            </span>
                        @endif
                        </p>

                    </div>
                </div>
            @endforeach
        </div>
        @endforeach

    </div>
</div>
<div class="col-md-12">
    <div class="wrapper center">
        {!! $articles->links() !!}
    </div>
</div>

@stop
