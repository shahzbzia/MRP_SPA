@extends('layouts.app')

@section('heroImageRooms')

	<div class="jumbo">
		<img src=" {{ isset($booking) ? asset("storage/app/public/".$booking->room->image) : asset("storage/".$room -> image)}}">
	</div>

@endsection

@section('content')


<div class="card card-default">
	
	<div class="card-header">
		{{ isset($booking) ? __('bookings.Edit Booking') : __('bookings.Booking') }}
	</div>

	<div class="card-body">

		<form action=" {{ isset($booking) ? route('edit', [app()->getLocale(), $booking->id, $room->id]) : route('bookings.store',[app()->getLocale(), $room->id]) }}" method="POST" >
			@csrf

			@if(isset($booking))
				@method('PUT')
			@endif

			<div class="form-group">
				
				<h5>{{ __('bookings.Room') }} : {{ isset($booking) ? $booking->room->name : $room->name }} </h5>

			</div>

			<div class="form-group">

				<h5>{{ __('bookings.Booked time slots') }} :

					@if(session()->has('fail') || $errors->any())
						
						<element id="dateColor" class="dataFromDB">{{ $slots }}</element>

					@elseif (isset($booking))

						<element id="dateColor">{{ $bookingSlot }}</element>

					@else

						 

					@endif

					<span id="getDate" class="liveData">    </span> 


				</h5>

			</div>

			<div class="form-group">
				
				<h5>{{ __('bookings.Client') }} : {{ Auth::user()->name }}</h5>

			</div>

			<div class="form-group">

				<label for="date">{{ __('bookings.Date') }}</label>

				@if (isset($booking))
					
				 	<input type="date" id="date" class="form-control" name="date" value="{{ $booking->date }}" readonly>

				@else

					<input type="date" id="date" class="form-control" name="date" value="{{ old('date') }}" required>

				@endif
				
			</div>


			<div class="form-group">

				<label for="start_time">{{ __('bookings.Start time') }}</label>
				
				@if (isset($booking))
					
					<input type="time" id="start_time" class="form-control" name="start_time" value="{{ $booking->start_time }}" readonly>

				@else

					<input type="time" id="start_time" class="form-control" name="start_time" value="{{ old('start_time') }}" required>

				@endif

			</div>

			<div class="form-group">

				<label for="end_time">{{ __('bookings.End time') }}</label>
				
				<input type="time" id="end_time" class="form-control" name="end_time" value="{{ isset($booking) ? $booking->end_time : old('end_time') }}" required>

			</div>

			@if (!isset($booking))

				<div class="form-group">

					<div class="mb-2">{{ __('bookings.Add other user(s)') }}</div>

					<div class="d-flex flex-column m-0">
						@foreach ($users as $u)
							<label class="m-0" for="linked_user[]"><input type="checkbox" name="linked_user[]" value="{{ $u->id }}"> {{ $u->name }} </label>
						@endforeach
					</div>

				</div>

			@endif

			<div class="form-group">
				
				<button class="btn btn-sm btn-dark" type="submit"> {{ isset($booking) ? __('bookings.Update') : __('bookings.Submit') }} </button>

				<a href="{{url()->previous()}}" class="btn btn-sm btn-outline-dark ml-2">Cancel</a>

			</div>

		</form>

	</div>

</div>

@endsection

@section('scripts')

	<script type="text/javascript">
		
		$(document).ready(function(){
			
			fetch_date();

			function fetch_date(query = ''){

				$.ajax({

					url:"{{ route('booking_controller.read') }}",
					method: 'GET',
					data:{query:query, room:{{ $room->id }}},
					dataType:'json',
					success:function(data){
						//console.log(data);
						$('#getDate').html(data);

						getData(data);
					},
					error:function(){
						console.log("error");
					}

				})

			}

			$(document).on('change', '#date', function(){
				var query = $(this).val();
				fetch_date(query);
				console.log(query);
			});

			function getData(param) {

			    $(document).on("change", '#date', function(){
		      	console.log(param);
		        $('.dataFromDB').empty();
		        $('#getDate').html(param);
	        	});

			}
		});

	</script>
	
@endsection