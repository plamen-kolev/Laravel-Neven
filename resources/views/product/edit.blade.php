@extends('master_page')
@section('content')
<div class="col-md-12">
    
    {!! Form::model($product, array('route' => array('product.update', $product->slug)))   !!}
    {!! Form::close() !!}
</div>


@stop