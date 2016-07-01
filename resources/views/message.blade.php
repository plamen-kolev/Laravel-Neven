@extends('master_page')
@section('content')
<div class="col-md-12">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        @if( isset($type) or isset($alert_text ) )
            <div class="wrapper">
                <div class="alert {{$type}}" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">{{$type}}:</span>
                    {{$message}}
                </div>
            </div>
        @else
            <p>
                {{$message}}
            </p>
        @endif
    </div>
    <div class="col-md-1"></div>

</div>
@stop
