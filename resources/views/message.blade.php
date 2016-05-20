@extends('master_page')
@section('content')
    <div class="col-md-12 alert {{$alert_type}}" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">{{$alert_text}}:</span>
        {{$message}}
    </div>
@stop
