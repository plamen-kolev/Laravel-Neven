@extends('base_response')
@section('content')
    <div class="col-md-12 http_container">
        <div class="wrapper">
            <div class="http_wrapper">
                <h1 class="http_code">404</h1>
                <p class="http_message">{{trans('text.404_verbose_message')}}</p>
                <a href="{{route('index')}}" class="generic_submit http_action">{{trans('text.error_action_button')}}</a>    
            </div>
        </div>        
    </div>

    <div class="col-md-12 error_video_tile_container">
        <div class="wrapper">
            <div class="col-md-1"></div>
            <video class="col-md-10 error_video" loop autoplay preload="none">
                <source src="{{asset('videos/grass.webm')}}"  type="video/mp4" />
                <source src="{{asset('videos/grass.webm')}}"  type="video/ogg" />
            </video>
            <div class="col-md-1"></div>
        </div>
    </div>
@stop

@section('response')
    {{trans('text.404_title')}}
@stop