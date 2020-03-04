@extends('layouts.app')

@section('content')


<div class="card card-default">
	
	<div class="card-header">
		{{ isset($room) ? 'Edit Room' : 'Create a Room' }}
	</div>

	<div class="card-body">

		
		<form action="{{ isset($room) ? route('rooms.update', $room->id) : route('rooms.store') }}" method="POST" enctype="multipart/form-data">
			@csrf

			@if(isset($room))
				@method('PUT')
			@endif

			<div class="form-group">
				<label for="name">Name of the room</label>
				
				<input type="text" id="name" class="form-control" name="name" value="{{ isset($room) ? $room->name : old('name') }}" required>

			</div>

			<div class="form-group">
				<label for="descriptionEN">Description in English</label>
				
				<textarea name="descriptionEN" id="descriptionEN" cols="5" rows="5" class="form-control" required>{{ isset($room) ? $room->getTranslation('description', 'en') : old('descriptionEN') }}
				</textarea>

			</div>

			<div class="form-group">
				<label for="descriptionNL">Description in Dutch</label>
				
				<textarea name="descriptionNL" id="descriptionNL" cols="5" rows="5" class="form-control" required>{{ isset($room) ? $room->getTranslation('description', 'nl') : old('descriptionNL') }}
				</textarea>

			</div>

			<div class="form-group">
				<label for="name">Location</label>
				
				<input type="text" id="location" class="form-control" name="location" value="{{ isset($room) ? $room->location : old('Location') }}" required>

			</div>

			@if(isset($room))

				<div class="form-group">
					
					<img id="roomImg" src="{{ asset("storage/app/public/".$room -> image) }}" style="width: 100%" >

				</div>

			@endif

			<div class="form-group">
				<label for="image">Image</label>
				
				<input type="file" id="image" class="form-control" name="image" required>

			</div>


			<div class="form-group">
				
				<button class="btn btn-sm btn-dark" type="submit">{{ isset($room) ? 'Update Room' : 'Create Room'  }}</button>

				<a href="{{url()->previous()}}" class="btn btn-sm btn-outline-dark ml-2">Back</a>


                <a href="{{ route('landingPage', app()->getLocale()) }}" class="btn btn-sm btn-outline-dark ml-2">Home</a>

			</div>

		</form>

	</div>

</div>

@endsection


@section('scripts')

		<script>
		   $(document).ready(function(){
		      $('#image').on("change", function(){
		         $('#roomImg').toggle();
		      });
		   });
		</script>

@endsection


