@extends('layouts.app')

@section('content')

<div class="card card-default table-responsive">
	
	<div class="card-header">

		List of Users

	</div>

	<div class="card-body">
	
		<table class="table table-responsive">
			
			<thead>
				<th>Name</th>
				<th>E-mail</th>
				<th>Role</th>
				<th></th>
				<th></th>
				<th></th>
			</thead>

			<tbody>
				@foreach($users as $user)
				<tr>
					
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->role->role_name}}</td>
					<td>
						
						<form action="{{ route('changeRole', $user->id) }}" method="POST">
							@csrf

							@method('PUT')

							@if ($user->role_id == 1)
								<button class="btn btn-warning btn-sm">Make Admin</button>
							@else
								<button class="btn btn-warning btn-sm">Make User</button>
							@endif

						</form>

					</td>
					<td>
						@if ($user->trashed())

							<form action="{{route('restore-user', $user->id)}}" method="POST">
									@csrf

									@method('PUT')

									<button type="submit" class="btn btn-info btn-sm"> Restore </button>

							</form>
							
						@endif
						

						

					</td>
					<td> 

						<form action="{{ route('users.destroy', $user->id) }}" method="POST">
						
						@csrf

						@method('DELETE')

						<button type="submit" class="btn btn-danger btn-sm">
							{{ $user->trashed() ? 'Delete' : 'Trash' }}
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
