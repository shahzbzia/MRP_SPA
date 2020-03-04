<template>
     <div class="card card-default">
	
		<div class="card-header">
			Bookings
		</div>

	<div class="card-body">

		<form>
			<div class="form-group">
				
				<h5>Room : </h5>

			</div>

			<div class="form-group">

				<h5>Booked time slots : </h5>

			</div>

			<div class="form-group">
				
				<h5>Client : </h5>

			</div>

			<div class="form-group">

				<label for="date">Date </label>

				<input type="date" id="date" class="form-control" name="date" value="" required>
				
			</div>


			<div class="form-group">

				<label for="start_time">Start Time</label>
				
				<input type="time" id="start_time" class="form-control" name="start_time" value="" required>

			</div>

			<div class="form-group">

				<label for="end_time">End Time</label>
				
				<input type="time" id="end_time" class="form-control" name="end_time" value="" required>

			</div>

			<div class="form-group">

				<div class="mb-2">Add other user(s)</div>

				<div class="d-flex flex-column m-0">

				</div>

			</div>

			<div class="form-group">
				
				<button class="btn btn-sm btn-dark" type="submit"> Submit </button>

				<a href="" class="btn btn-sm btn-outline-dark ml-2">Cancel</a>

			</div>

		</form>

	</div>

</div>
</template>

<script>
    export default {

    }
</script>