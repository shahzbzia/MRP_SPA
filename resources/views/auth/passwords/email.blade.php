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
                <div class="card-header">{{ __('auth.Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email', app()->getLocale()) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('auth.Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
