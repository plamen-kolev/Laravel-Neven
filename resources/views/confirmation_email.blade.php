@extends('base_email')
@section('content')

<h1>{{$verify_email_text}}</h1>

<div>
    {!!  html_entity_decode($body) !!}
</div>

@stop