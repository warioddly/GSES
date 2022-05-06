@extends('layouts.auth')

@section('content')

    <form class="form-signin" method="POST" action="{{ route('register') }}" style="padding-top: 10%;">
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
                <div class="atomic-number" style="text-align: center;font-size: x-large;margin-top: 10px;">{{ __('Register') }}</div>
                <div class="form-group form-animate-text @error('name') has-error @enderror" style="margin-top:20px !important;">
                    <input type="text" name="name" id="name" class="form-text" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="help-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="bar"></span>
                    <label>{{ __('Name') }}</label>
                </div>
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
                    <input type="password" id="password" class="form-text" name="password" required autocomplete="current-password">
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
                <input type="submit" class="btn col-xs-12 col-md-12" value="{{ __('Register') }}" style="margin-top: 13px;"/>
            </div>
            @if (Route::has('password.request'))
                <div class="text-center" style="padding:5px;" >
                    <a href="{{ route('login') }}">{{ __('Login') }} </a>
                    <a class="delimiter"> | </a>
                    <span class="login-lang">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu lang-dropdown">
                        @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <li><a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </span>
                </div>
            @endif
        </div>
    </form>

@endsection
