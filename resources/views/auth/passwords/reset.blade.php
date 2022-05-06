@extends('layouts.auth')

@section('content')

<form class="form-signin" method="POST" action="{{ route('password.update') }}" style="padding-top: 10%;">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="panel periodic-login">
        <div class="panel-body text-center">
            <div class="row">
                <div class="col-xs-4 col-sm-4">
                    <img  src="{{url('asset/img/GSES.jpg')}}" style="height: 80px"/>
                </div>
                <div class="col-xs-8 col-sm-8">
                    <div class="atomic-number" style="text-align: center;font-size: xx-large;line-height: 80px;">{{ config('app.name', 'Laravel') }}</div>
                </div>
            </div>
            <div class="atomic-number" style="text-align: center;font-size: x-large;margin-top: 10px;">{{ __('Reset Password') }}</div>
            <div class="form-group form-animate-text @error('email') has-error @enderror" style="margin-top:20px !important;">
                <input type="email" name="email" id="email" class="form-text" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="help-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="bar"></span>
                <label>{{ __('E-Mail Address') }}</label>
            </div>
            <div class="form-group form-animate-text @error('password') has-error @enderror" style="margin-top:10px !important;">
                <input type="password" id="password" class="form-text" name="password" required autocomplete="new-password">
                @error('password')
                <span class="help-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="bar"></span>
                <label>{{ __('Password') }}</label>
            </div>
            <div class="form-group form-animate-text" style="margin-top:10px !important;">
                <input type="password" id="password-confirm" class="form-text" name="password_confirmation" required autocomplete="new-password">
                <span class="bar"></span>
                <label>{{ __('Confirm Password') }}</label>
            </div>
            <input type="submit" class="btn col-xs-12 col-md-12" value="{{ __('Reset Password') }}" style="margin-top: 13px;white-space: normal;"/>
        </div>
    </div>
</form>

@endsection
