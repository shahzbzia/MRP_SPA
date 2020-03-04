@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">

                <div class="card card-default">
                    <div class="card-header">Send Invitation</div>

                    <div class="card-body">
                        <p>You can send an invitation for {{ config('app.name') }} by entering user's email address below.</p>

                        <form class="form-horizontal" method="POST" action="{{ route('storeInvitation') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <button type="submit" class="btn btn-sm btn-dark">
                                        Invite
                                    </button>

                                    <a href="{{url()->previous()}}" class="btn btn-sm btn-outline-dark ml-2">Back</a>


                                    <a href="{{ route('landingPage', app()->getLocale()) }}" class="btn btn-sm btn-outline-dark ml-2">Home</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection