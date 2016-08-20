@extends('master_page')

@section('login')
<div class="col-md-12">
    <div class="wrapper">
        <h1 class="capital center">{{trans('text.log_in')}}</h1>
        <div class="col-md-12">

        <div class="col-md-4"></div>
        <div class="col-md-4">
            @if( $errors->all() )
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            <form class="generic_form" role="form" method="POST" action="{!! route('auth.login') !!}">
                {!! csrf_field() !!}

                <p><input class="generic_input" type="email" id="login_email_field" placeholder="{{trans('text.email_address')}}" name="email" value="{{ old('email') }}"/></p>

                <p><input class="generic_input"  id="password" type="password" placeholder="{{trans('text.password')}}"  name="password"/></p>

                <p>{{trans('text.remember_me')}}<input type="checkbox" name="remember"/></p>

                <input type="submit" class="generic_submit" value="{{trans('text.log_in')}}"/>
                <a class="btn btn-link" href="{!! route('auth.password.reset') !!}">{{trans('text.forgotten_password_question')}}</a>

            </form>

        </div>
        <div class="col-md-4"></div>
    </div>
</div>
@endsection
