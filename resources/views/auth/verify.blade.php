@extends('layouts.auth')

@section('content')

    <form class="form-signin" method="POST" action="{{ route('verification.resend') }}" style="padding-top: 10%;">
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
                <div class="atomic-number" style="text-align: center;font-size: x-large;margin-top: 10px;">{{ __('Verify Your Email Address') }}</div>
                @if (session('resent'))
                    <p class="bg-success">{{ __('A fresh verification link has been sent to your email address.') }}</p>
                @endif
                <p class="bg-info">{{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <button type="submit" class="" style="white-space: normal;margin-top: 0;display: contents; text-decoration: underline;">{{ __('click here to request another') }}</button>.
                </p>
            </div>
        </div>
    </form>
@endsection
