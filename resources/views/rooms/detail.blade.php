@extends('layouts.app')

@extends('layouts.header')

@section('content')

<body>
    <div class="container">
        
        <div class="d-flex justify-content-center">

            <div class="card">
                <div class="row">
                    <aside class="col-sm-5 border-right">
                        <article class="gallery-wrap"> 
                            <div class="img-big-wrap">
                              <div> <a href="#"><img src="{{ asset("storage/".$room -> image) }} " width="110%"></a></div>
                            </div>
                        </article>
                    </aside>

                    <aside class="col-sm-7 pl-5">
                        <article class="card-body p-4">
                            <h2 class="title mb-3">{{$room -> name}}</h2>

                            <dl class="item-property mt-2">
                              <dt>Description</dt>
                              <dd><p>{{$room -> description}}</p></dd>
                            </dl>

                            <div class="row mt-2">
                                <div class="col-sm-5">
                                    <dl class="param param-inline">
                                      <h6><strong> Location: </strong>{{$room->location}}</h6>
                                </div>      
                            </div>

                            <div class="d-flex mt-2">
                                {{-- <form action="" method="get">
                                    @csrf

                                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                                    <button type="submit" class="btn btn-lg btn-primary text-uppercase"> Book </button>

                                </form> --}}

                                <a href="{{ route('bookings.create', $room->id) }}" class="btn btn-lg btn-dark text-uppercase"> BOOK </a>

                                <a href="{{route('landingPage')}}" class="btn btn-lg btn-outline-dark mx-2" style="height: 46px"> HOME </a>
                            </div>
                        </article>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</body>



@endsection 