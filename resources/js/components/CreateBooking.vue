<template>
     <div class="card card-default">
	
		<div class="card-header">
			Bookings
		</div>

	<div class="card-body">

		<form @submit.prevent="sendData">
			<div class="form-group">
				
				<h5>Room : {{ room.name }}</h5>

			</div>

			<div class="form-group">

				<h5>Booked time slots : </h5>

			</div>

			<div class="form-group">
				
				<h5>Client : {{ user.name }}</h5>

			</div>

			<div class="form-group">

				<label for="date">Date </label>

				<!-- <input type="date" id="date" class="form-control" name="date" value="" required> -->

				<date-picker v-model="date" :disabled-date="notBeforeToday" type="date" value-type="format" @change="dateChanged"> </date-picker>
				
			</div>


			<div class="form-group">

				<label for="start_time">Start Time</label>
				
				<input v-model="booking.start_time" type="time" id="start_time" class="form-control" name="start_time" value="" required>

			</div>

			<div class="form-group">

				<label for="end_time">End Time</label>
				
				<input v-model="booking.end_time" show-hour="false" type="time" id="end_time" class="form-control" name="end_time" value="" required>

			</div>

			<div class="form-group">

				<div class="mb-2">Add other user(s)</div>

				<div v-for="otherUser in otherUsers" class="d-flex flex-column m-0">
					<label class="m-0" for="linked_user[]">

					<input type="checkbox" name="linked_user[]" :value='otherUser.id' v-model='linkedUsers' > {{ otherUser.name }} </label>
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
	import DatePicker from 'vue2-datepicker';
	import 'vue2-datepicker/index.css';

	const today = new Date();
	today.setHours(0, 0, 0, 0);



    export default {
    	components: { DatePicker },
    	data() {
            return {

                room: [],
                user: [],
                date: new Date(),
                booking: {},
                otherUsers: [],
                linkedUsers: [],

            }
        },
        created() {

            this.axios
                .get(`/api/rooms/${this.$route.params.id}`)
                .then((response) => {
                    this.room = response.data.data;
                    this.user = response.data.user;
                    this.otherUsers = response.data.otherUsers;

                    //console.log(this.otherUsers);
                });
        },

        methods: {
        	dateChanged: function(){
        		//console.log();
        	},

        	notBeforeToday(date) {
		      return date < today;
		    },

        	sendData() {
        		console.log(this.booking, this.date, this.room.id, this.user.id, this.linkedUsers);
                this.axios
                    .post('/api/booking/store', 
                    	{start_time : this.booking.start_time, 
                    	 end_time : this.booking.end_time,
                    	 date: this.date, 
                    	 room_id: this.room.id, 
                    	 user_id: this.user.id,
                    	 linked_user: this.linkedUsers})
                    .then(response => (
                        this.$router.push({name: 'landingPage'}),
                        console.log('response.data')
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)   
            }
        }
    }
</script>