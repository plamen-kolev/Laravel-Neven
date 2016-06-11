@extends('master_page')
@section('content')
<div class="col-md-12 nomargin nopadding">
    <h1 class="capital center">{{trans('text.become_stockist')}}</h1>


    <div class="parallax">
        <div class="bg__rose_1"></div>
    </div>

    <div class="parallax">
        <div class="bg__rose_blur"></div>
    </div>

    <div class="parallax">
        <div class="bg__rose_2"></div>
    </div>

    <div class="wrapper" id="stockist_form">
        <div class="col-md-4"></div>
        <div class="col-md-4" id="stockist_container">
            @if( $errors->all() )
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            {!! Form::open(array('url' => route('stockist') )) !!}
                <p>{!! Form::text('first_name', Input::old('first_name'), array('placeholder' => trans("text.first_name"), 'class' => 'generic_input' )); !!}</p>
                <p>{!! Form::text('last_name', Input::old('last_name'), array('placeholder' => trans("text.last_name"), 'class' => 'generic_input' )); !!}</p>
                <p>{!! Form::text('email', Input::old('email'), array('placeholder' => trans("text.email") , 'class' => 'generic_input')); !!}</p>
                <p>{!! Form::text('website', Input::old('website'), array('placeholder' => trans("text.website"), 'class' => 'generic_input' )); !!}</p>
                <p>{!! Form::text('company', Input::old('company'), array('placeholder' => trans("text.company_name"), 'class' => 'generic_input' )); !!}</p>
                <p>
                    {!! Form::textarea('about_you', Input::old('about_you'), 
                            array(
                                'placeholder' => trans("text.about_you"),
                                'maxlength'=>'5000',
                                'class' => 'generic_input'
                            ) 
                        ); 
                    !!}
                </p>
                <div>
                <p>{!! Form::submit(trans('text.submit'), array('class' => 'generic_submit width_65') )!!}</p>    
                </div>
                
            {!! Form::close() !!}
        </div>
        <div class="col-md-4"></div>
    </div>


</div>
@stop