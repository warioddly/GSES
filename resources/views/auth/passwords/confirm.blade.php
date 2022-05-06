@extends('layouts.auth')

@section('content')

<form class="form-signin" method="POST" action="{{ route('password.confirm') }}" style="padding-top: 10%;">
    @csrf
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
            <div class="atomic-number" style="text-align: center;font-size: x-large;margin-top: 10px;">{{ __('Confirm Password') }}</div>
            <p class="bg-info">{{ __('Please confirm your password before continuing.') }}</p>
            <div class="form-group form-animate-text @error('password') has-error @enderror" style="margin-top:10px !important;">
                <input type="password" id="password" class="form-text" name="password" required autocomplete="current-password">
                @error('password')
                <span class="help-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="bar"></span>
                <label>{{ __('Password') }}</label>
            </div>
            <input type="submit" class="btn col-xs-12 col-md-12" value="{{ __('Confirm Password') }}" style="margin-top: 13px;white-space: normal;"/>
        </div>
        @if (Route::has('password.request'))
            <div class="text-center" style="padding:5px;" >
                <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }} </a>
            </div>
        @endif
    </div>
</form>

@endsection
