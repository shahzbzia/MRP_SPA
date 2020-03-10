<template>
 <div id="app" class="card card-default">
	
		<div class="card-header d-flex justify-content-md-between">

			Extend bookings

			<router-link :to="{ name: 'myBookings'}" class="btn btn-sm btn-dark ml-2"> Back </router-link>

		</div>

	<div class="card-body">

		<form @submit.prevent="updateBooking">
			<div class="form-group">
				
				<h5 v-if="booking.room">Room : {{ booking.room.name }}</h5>
				<h5 v-else>Room : Loading...</h5>

			</div>

			<div class="form-group">

				<h5 v-text>Booked time slots : {{ slots }}</h5>

			</div>

			<div class="form-group">
				
				<h5 v-if="booking.user">Client : {{ booking.user.name }}</h5>
				<h5 v-else>Client : Loading...</h5>

			</div>

			<div class="form-group">

				<label for="date">Date </label>

				<input type="date" id="date" class="form-control" name="date" :value="booking.date" readonly>

				
			</div>


			<div class="form-group">

				<label for="start_time">Start Time</label>
				
				<input v-model="booking.start_time" type="time" id="start_time" class="form-control" name="start_time" value="" readonly="">

			</div>

			<div class="form-group">

				<label for="end_time">End Time</label>
				
				<input v-model="booking.end_time" show-hour="false" type="time" id="end_time" class="form-control" name="end_time" value="" required>

				<span class="text-danger" v-if="errors.has('end_time')">{{ errors.get('end_time') }}</span>

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

	class Errors{

		constructor() {

			this.errors = {};

		}

		get(field) {

			if (this.errors[field]){

				return this.errors[field][0];

			}

		}

		record(errors){

			this.errors = errors;

		}

		clear(field){

			delete this.errors[field];

		}

		has(field){

			return this.errors.hasOwnProperty(field);

		}

	}

    export default {
    	data() {
            return {

                booking: {},
                slots: '',
                errors: new Errors(),

            }
        },
        created() {

            this.axios
                .get(`/api/user/dashboard/extend/${this.$route.params.id}`)
                .then((response) => {
                    this.booking = response.data.data;
                    this.slots = response.data.slots;

                });
        },

        methods: {

        	updateBooking() {

        		var that = this;

        		this.axios
                    .post(`/api/user/dashboard/extend/store/${this.$route.params.id}`, 
                    	{end_time : this.booking.end_time,
                    	 date: this.booking.date, 
                    	 room_id: this.booking.room.id, 
                    	 user_id: this.booking.user.id,
                    	 start_time: this.booking.start_time,})
                    .then(response => (
                    	
                    	setTimeout(() => that.$router.push({name: 'landingPage'}), 200),

                    	alert('Booking extended sucessfully')

                    ))

                    .catch(error => {
					    if (error.response.status == 422) {
					        this.errors.record(error.response.data.errors);
					    }

					    else {
					    	alert(error.response.data.message)
					    }
					});

        	}

        }
    }
</script>