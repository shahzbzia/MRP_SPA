@extends('layouts.app')

@section('jumbotron')

    <div class="jumbotron jumbotron-fluid text-center darken" style="margin-bottom:0">
        <div class="container extraPadding">

            <div>
                <h4 class="text"><strong>{{ __('welcome.BOOK MEETING ROOMS IN ADVANCE TO SAVE TIME AND MAKE YOUR WORKPLACE BETTER') }}</strong></h4>
                <p class="text">{{__('welcome.Use our meeting rooms for presentations, interviews, client pitches or training for your company. We also provide a number of meeting spaces as conference rooms')}} 
                {{__('welcome.and boardrooms for rent. Catering, coffee service, projection equipment and other services are available to ensure you have everything you need for your meeting.')}} </p>
                <p class="text">{{ __('welcome.Just show up and get started.') }}</p>
            </div>
            
        </div>  
    </div>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('auth.Before proceeding, please check your email for a verification link.') }}
                    {{ __('auth.If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend', app()->getLocale()) }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
