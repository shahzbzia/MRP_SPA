@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-end mb-2">

	<a href="{{ route('rooms.create') }}" class="btn btn-dark float-right mx-2">Create Rooms</a>

</div>
<div class="card card-default table-responsive">
	
	<div class="card-header">

		Meeting Rooms

	</div>

	<div class="card-body">
	
		<table class="table">
			
			<thead>
				<th>Image</th>
				<th>Name</th>
				<th>Description</th>
				<th>Location</th>
				<th></th>
				<th></th>
			</thead>

			<tbody>
				@foreach($rooms as $room)
				<tr>
					
					<td><img src="{{ asset("storage/app/public/".$room -> image) }}" width="50" height="50" ></td>
					<td>{{ $room->name }}</td>
					<td>{{ $room->description }}</td>
					<td>{{ $room->location }}</td>
					<td>
						@if (!$room->trashed())
							<a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-info btn-sm"> Edit </a>
						@else

							<form action="{{route('restore-room', $room->id)}}" method="POST">
									@csrf

									@method('PUT')

									<button type="submit" class="btn btn-info btn-sm"> Restore </button>

							</form>
							
						@endif

						

					</td>
					<td> <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
						
						@csrf

						@method('DELETE')

						<button type="submit" class="btn btn-danger btn-sm">
							{{ $room->trashed() ? 'Delete' : 'Trash' }}
						</button>

					</form>
					</td>

				</tr>
				@endforeach

			</tbody>

		</table>

	</div>

</div>



@endsection
