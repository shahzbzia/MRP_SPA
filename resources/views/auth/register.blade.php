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
                <div class="card-header">{{ isset($user) ? __('auth.Edit Profile') : __('auth.Register') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ isset($user) ? route('editUsers', [app()->getLocale(), Auth::user()->id]) : route('register', app()->getLocale()) }}">
                        @csrf

                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('auth.Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($user) ? $user->name : old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @guest
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control disabled" value="{{ $email ?? '' }}" disabled>
                                <input id="email" type="hidden" class="form-control disabled" name="email" value="{{ $email ?? '' }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endguest

                        <div class="form-group row">
                            <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('auth.Street') }}</label>

                            <div class="col-md-6">
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ isset($user) ? $user->street : old('street') }}" required autocomplete="street" autofocus>

                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="house_number" class="col-md-4 col-form-label text-md-right">{{ __('auth.House number') }}</label>

                            <div class="col-md-6">
                                <input id="house_number" type="text" class="form-control @error('house_number') is-invalid @enderror" name="house_number" value="{{ isset($user) ? $user->house_number : old('house_number') }}" required autocomplete="house_number" autofocus>

                                @error('house_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="post_code" class="col-md-4 col-form-label text-md-right">{{ __('auth.Post code') }}</label>

                            <div class="col-md-6">
                                <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{ isset($user) ? $user->post_code : old('post_code') }}" required autocomplete="post_code" autofocus>

                                @error('post_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('auth.City') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control @error('house_number') is-invalid @enderror" name="city" value="{{ isset($user) ? $user->city : old('city') }}" required autocomplete="city" autofocus>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('auth.Country') }}</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ isset($user) ? $user->country : old('country') }}" required autocomplete="country" autofocus>

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @guest
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('auth.Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        @endguest
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{isset($user) ? __('auth.Update') : __('auth.Register') }}
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
