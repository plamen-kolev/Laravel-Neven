@extends('master_page')
@section('content')
<div class="col-md-12 nomargin nopadding">
    <h1 class="capital center">{{trans('text.become_stockist')}}</h1>

    <div id="hero">
        <div class='layer' data-depth='0.10' data-type='parallax'>
             <div class="layer-inner layer-generic-back-left pull-left"></div>
             <div class="layer-inner layer-generic-back-right pull-right"></div>
        </div>
        <div class='layer' data-depth='0.40' data-type='parallax'>
             <div class="layer-inner layer-generic-front-left pull-left"></div>
             <div class="layer-inner layer-generic-front-right pull-right"></div>
         </div>
    </div>

    <div class="wrapper">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            @if( $errors->all() )
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            {!! Form::open(array('url' => route('stockist'), 'class' => 'generic_form', 'id' => '' )) !!}
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
        <div class="col-md-3"></div>
    </div>


</div>
@stop