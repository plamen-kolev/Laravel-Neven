@extends('master_page')
@section('content')
<div class="col-md-12 http_container">
    <div class="wrapper">
        <div class="http_wrapper">
            <h1 class="http_code">500</h1>
            {{$errors}}
            <p class="http_message">{{trans('text.500_verbose_message')}}</p>
            <a href="{{route('index')}}" class="generic_submit http_action">{{trans('text.500_action_button')}}</a>    
        </div>
    </div>        
</div>

<video class="error_video" width="1080" loop autoplay preload="none">
    <source src="{{asset('videos/grass.webm')}}"  type="video/mp4" />
    <source src="{{asset('videos/grass.webm')}}"  type="video/ogg" />
</video>
@stop

@section('response')
    {{trans('text.500_title')}}
@stop