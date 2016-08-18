@extends('base_response')
@section('content')
<div class="col-md-12 http_container">
    <div class="wrapper">
        <div class="http_wrapper">
            <h1 class="http_code">403</h1>
            <p class="http_message">{{trans('text.403_verbose_message')}}</p>
            <a href="{{route('index')}}" class="generic_submit http_action">{{trans('text.error_action_button')}}</a>
        </div>
    </div>
</div>

<div class="col-md-12 error_video_tile_container pull_right">
    <div class="col-md-1"></div>
    <video class="col-md-10 error_video pull-right 403_video" loop autoplay preload="none" style="max-width:994px;">
        <source src="{{asset('videos/bird_house.webm')}}"  type="video/mp4" />
        <source src="{{asset('videos/bird_house.webm')}}"  type="video/ogg" />
    </video>
    <div class="col-md-1"></div>
</div>
@stop

@section('response')
    {{trans('text.403_title')}}
@stop
