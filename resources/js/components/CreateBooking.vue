<template>
 <div id="app" class="card card-default">
	
		<div class="card-header d-flex justify-content-md-between">
			
			Create bookings

			<router-link :to="{ name: 'landingPage'}" class="btn btn-sm btn-dark ml-2"> Back </router-link>

		</div>

	<div class="card-body">

		<form @submit.prevent="sendData" @click="errors.clear($event.target.name)">
			<div class="form-group">
				
				<h5>Room : {{ room.name }}</h5>

			</div>

			<div class="form-group">

				<h5 v-text>Booked time slots : {{ slots }}</h5>

			</div>

			<div class="form-group">
				
				<h5>Client : {{ user.name }}</h5>

			</div>

			<div class="form-group">

				<label for="date">Date </label>

				<input type="date" id="date" class="form-control" name="date" v-model="date" @change="dateChanged" required>
				
				<span class="text-danger" v-if="errors.has('date')"> {{ errors.get('date') }}</span>
				
			</div>


			<div class="form-group">

				<label for="start_time">Start Time</label>
				
				<input v-model="booking.start_time" type="time" id="start_time" class="form-control" name="start_time" value="" required>

				<span class="text-danger" v-if="errors.has('start_time')">{{ errors.get('start_time') }}</span>

			</div>

			<div class="form-group">

				<label for="end_time">End Time</label>
				
				<input v-model="booking.end_time" show-hour="false" type="time" id="end_time" class="form-control" name="end_time" value="" required>

				<span class="text-danger" v-if="errors.has('end_time')">{{ errors.get('end_time') }}</span>

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

                room: [],
                user: [],
                date: '',
                booking: {},
                otherUsers: [],
                linkedUsers: [],
                timestamp: '',
                errors: new Errors(),
                message: '',
                slots: '',

            }
        },
        created() {

            this.axios
                .get(`/api/rooms/${this.$route.params.id}`)
                .then((response) => {
                    this.room = response.data.data;
                    this.user = response.data.user;
                    this.otherUsers = response.data.otherUsers;
            });

        },

        methods: {
        	dateChanged: function(){
        		//console.log(this.date, this.room.id);

        		this.axios
	                .post(`/api/get/booking/slots`, 
	                	{date: this.date, 
                    	 room_id: this.room.id})
	                .then((response) => {
	                	this.slots = response.data.slots
	                	//console.log(this.slots)
	            });

        	},

        	sendData() {

        		var that = this;
                this.axios
                    .post('/api/booking/store', 
                    	{start_time : this.booking.start_time, 
                    	 end_time : this.booking.end_time,
                    	 date: this.date, 
                    	 room_id: this.room.id, 
                    	 user_id: this.user.id,
                    	 linked_user: this.linkedUsers})
                    .then(response => (

                    	setTimeout(() => that.$router.push({name: 'landingPage'}), 200),

                    	alert('Room booked successfully')

                    ))

                    .catch(error => {
					    if (error.response.status == 422) {
					        this.errors.record(error.response.data.errors);
					    }

					    else {
					    	alert(error.response.data.message)
					    }
					});
            },

    }

}
</script>