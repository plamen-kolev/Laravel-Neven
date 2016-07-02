@extends('base_email')
@section('content')

<p>First name: {{$first_name}}</p>
<p>Last name: {{$last_name}}</p>
<p>Email: {{$email}}</p>

@if( ! empty($data['website']))
	<p>Website: {{$website}}</p> 
@endif

@if( ! empty($data['telephone']))
	<p>Telephone: {{$telephone}}</p> 
@endif

@if( ! empty($data['company']))
	<p>Company: {{$company}}</p> 
@endif

<p>About: {{$about}}</p>
@stop