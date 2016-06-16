@extends('master_page')
@section('content')
<div class="col-md-12">
    @if( isset($alert_type) or isset($alert_text ) )
        <div class="wrapper">
            <div class="alert {{$alert_type}}" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">{{$alert_text}}:</span>
                {{$message}}
            </div>
        </div>
    @else
        <p>
            {{$message}}
        </p>
    @endif

</div>
@stop
