@extends('master_page')

@section('content')
    <div class="col-md-12">
        <div class="wrapper">
            @foreach ($objects as $hero)
                <div id="landing_player">
                    <h1 class="center captial">{{$hero->title_en}}</h1>
                    {{ Form::open(['method' => 'DELETE', 'route' => ['hero.destroy', $hero->id]]) }}
                        {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                    {{ Form::close() }}

                    <a class="glyphicon glyphicon-pencil success" href="{{route('hero.edit', $hero->id)}}"></a>

                    <video autoplay loop poster="{{asset("videos/thumbnails/$hero->image")}}" id="landing_video" >
                        <source src="{{asset("videos/$hero->video")}}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @endforeach
        </div>
    </div>
@stop
