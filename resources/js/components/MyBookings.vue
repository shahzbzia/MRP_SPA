<template>
	
	
		<div class="container" id="app">
		    <div class="row justify-content-center">
		        <div class="col-md-12">
		            <div class="card table-responsive">
		                <div class="card-header d-flex justify-content-md-between">

		                Booking History

		                <router-link :to="{ name: 'landingPage'}" class="btn btn-sm btn-dark ml-2"> Back </router-link>

		                </div>

		                <div class="card-body">

		                    <div >
			                    <table class="table">
			            
			                        <thead>
			                            <th>Image</th>
			                            <th>User Name</th>
			                            <th>Room Name</th>
			                            <th>Created at</th>
			                            <th>Booking Date</th>
			                            <th>Booking Time</th>
			                            <th>Extend / Cancel</th>
			                        </thead>

			                        <tbody>
			                            <tr v-for="booking in bookings" :key="booking.id">
			                                
			                                <td><img :src="getImage(booking.room.image)" width="50" height="50" >{{ booking.id }}</td>
			                                <td>{{ booking.user.name}}</td>
			                                <td>{{ booking.room.name}}</td>
			                                <td>{{ booking.created_at }}</td>
			                                <td>{{ booking.date }}</td>
			                                <td>{{ booking.start_time }} - {{ booking.end_time }}</td>
			                                
			                                <td v-if="booking.user_id == user.id">

			                                	<span v-if="getNow() <= getTimeString(booking.date, booking.end_time)">
			                                		
													<router-link :to="{ name: 'extendBooking', params: { id: booking.id }}" class="btn btn-sm btn-dark">  Extend </router-link>

													<button class="btn btn-sm btn-dark" @click="deleteBook(booking.id)"> Cancel </button>

			                                	</span>

			                                	<span v-else>Meeting Finished!</span>
			                                    
			                                    <!-- 
			                                        @if(\Carbon\Carbon::now('CET')->format('Y-m-dH:i:s') <= $booking->date.$booking->end_time)

			                                        	<a href="{{  route('editForm', [app()->getLocale(), $booking->id, $booking->room_id, $booking->date]) }}" class="btn btn-sm btn-dark"> Extend </a>
			                                            
			                                        @endif
			                                     -->

			                                </td>

			                                <td v-else>Linked Booking!</td>

										</tr>
			                        </tbody>

			                    </table>

		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>



</template>

<script>
	
	export default{

    	data() {
            return {

                user: [],
                date: new Date(),
                bookings: [],
                timestamp: '',

            }
        },
        created() {

            this.axios
                .get(`/api/user/dashboard`)
                .then((response) => {
                    this.bookings = response.data.bookings;
                    this.user = response.data.user;
                    //console.log(this.timestamp);
                });
        },

        methods: {

            getNow: function() {
                const today = new Date();
                var month = '' + (today.getMonth() + 1);
                var day = '' + today.getDate();
                var year = today.getFullYear();
                var hour = '' +  today.getHours();
                var min = '' +  today.getMinutes();
                var sec = '' +  today.getSeconds();

                if (month.length < 2) 
		        	month = '0' + month;
			    if (day.length < 2) 
			        day = '0' + day;
			    if (hour.length < 2) 
		        	hour = '0' + hour;
		    	if (min.length < 2) 
		        	min = '0' + min;
			    if (sec.length < 2) 
			        sec = '0' + sec;
		    
                const date = year+'-'+month+'-'+day;
                const time = hour+":"+min+":"+sec;
                const dateTime = date +' '+ time;
                this.timestamp = dateTime;
                return this.timestamp;
            },

            getImage: function(image){
                return "/storage/"+image;
            },

            getTimeString: function(date, time){
            	var timeString = date + ' ' + time;
            	return timeString;
            },

            deleteBook: function(id) {
                this.axios
                    .delete(`/api/user/dashboard/delete/${id}`)
                    .then(response => {
                        let i = this.bookings.map(item => item.id).indexOf(id); // find index of your object
                        this.bookings.splice(i, 1);

                        setTimeout(() => alert('Booking deleted successfully'), 200);

                        
                    });
            },

        },

    }

</script>