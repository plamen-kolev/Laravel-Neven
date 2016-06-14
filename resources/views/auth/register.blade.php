@extends('master_page')

@section('register')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h1 class="capital center">{{trans('text.sign_up')}}</h1>
            <div class="panel register_container">
                
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{!! route('auth.register') !!}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('text.name')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="generic_input" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('text.email_address')}}</label>

                            <div class="col-md-6">
                                <input type="email" class="generic_input" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('text.password')}}</label>

                            <div class="col-md-6">
                                <input type="password" class="generic_input" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('text.confirm_password')}}</label>

                            <div class="col-md-6">
                                <input type="password" class="generic_input" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input class="generic_submit" type="submit" value="{{trans('text.sign_up')}}" id="user_register_button"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
