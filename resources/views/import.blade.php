@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

    <div class="col-md-12">

        <div class="card">
                
            <div class="card-header">Import rooms from excel</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                

                <div class="d-flex">
                    
                    <form action="{{route('rooms.import')}}" method="POST" enctype="multipart/form-data">
                        
                        @csrf

                        <input type="file" name="excel" required>
                            
                        <button class="btn btn-dark btn-sm">Import</button>

                    </form>

                    <a href="{{url()->previous()}}" class="btn btn-sm btn-outline-dark ml-2">Back</a>


                    <a href="{{ route('landingPage', app()->getLocale()) }}" class="btn btn-sm btn-outline-dark ml-2">Home</a>

                </div>


            </div>
                
        </div>
        
        
        
    </div>

</div>
</div>
@endsection

