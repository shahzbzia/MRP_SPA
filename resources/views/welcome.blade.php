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
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body>
        {{-- <div id="results" class="full-width mt-5 text-center"></div> --}}
        <div id="app">
            <router-view></router-view>
        </div>
    </body>
</html>
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script>

    var page = 1;

    load_more(page);

    $(window).scroll(function() { 

      if($(window).scrollTop() + $(window).height() >= $(document).height()) {
          page++;
          load_more(page);
      }

    });     

    function load_more(page){

        $.ajax({

           url: '?page=' + page,
           type: "get",
           datatype: "html",

        })

        .done(function(data)
        {
            $("#results").append(data);      
            console.log('data.length');
       })

       .fail(function(jqXHR, ajaxOptions, thrownError)
       {
          alert('No response from server. Please try again later.');
       });

    }

</script>

@endsection