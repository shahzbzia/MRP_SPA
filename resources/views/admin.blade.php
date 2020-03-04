@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

    <div class="col-md-12">

        <div class="card">
                
            <div class="card-header">Admin Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                

                Welcome Admin <strong style="color: blue">{{ Auth::user()->name }}</strong> 


            </div>
                
        </div>
        
        
        
    </div>

</div>
</div>
@endsection

