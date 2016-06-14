@extends('master_page')
@section('content')
    <div class="col-md-12">
        <div class="wrapper">
            @if(Auth::user() && Auth::user()->admin)
                <a class="generic_submit" href="{{route('blog.create')}}">Create an Article</a>
            @endif

            @foreach($articles as $article)
                <div class="well">
                    @if(Auth::user() && Auth::user()->admin)
                        {!! Form::model($article, array('route' => array('blog.destroy', $article->slug), 'method'=>'delete'  )) !!}
                            {!! Form::submit('delete', array('class' => '') )!!}
                        {!! Form::close() !!}

                        <a href="{{route('blog.edit', $article->slug)}}">Edit</a>
                    @endif
                    <h1><a href="{{ route('blog.show', $article->slug) }}">{{$article->title}}</a></h1>

                    <p>{!! $article->body !!}</p>
                    <p>{{$article->updated_at}}</p>
                    <p>Tags: {{$article->tags}}</p>
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
