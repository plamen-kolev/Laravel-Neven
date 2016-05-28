@extends('master_page')
@section('content')
    <div class="col-md-12">
        <div class="wrapper">
            @if( $errors->all() )
            <div class="col-md-12">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
            @endif  


        </div>
    </div>
    <div class="col-md-12">
        <div class="wrapper">

        <h1 class="capital center">Write a new article</h1>

        {!! Form::model($article, array('route' => array('blog.store'))  ) !!}
        
        
        <div class="col-md-12">
            {!! Form::text('title', Input::old('title'), array('placeholder' => 'Product title', 'class' => 'generic_input' )); !!}
        </div>



        <div class="col-md-12">
            <p>Body</p>
            {!! Form::textarea('body', Input::old('body'), 
                    array(
                        'placeholder' => 'Body',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                ); 
            !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('tags', Input::old('tags'), array('placeholder' => 'Visible tags(coma separate them)', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('hidden_tags', Input::old('hidden_tags'), array('placeholder' => 'Hidden tags', 'class' => 'generic_input' )); !!}
        </div>



        <div class="col-md-12">
            {!! Form::submit('Add product', array('class' => 'generic_submit') )!!}
        </div>

    {!! Form::close() !!}
</div>



    </div>
    </div>

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>

$( document ).ready(function() {
     
        $('textarea').ckeditor();
});

</script>
@stop
