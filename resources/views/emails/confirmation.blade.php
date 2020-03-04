<body>
	
	Hello <strong>{{ Auth::user()->name }}</strong>,

	<br>

	<p>This is an automated room booking confirmation message for {{ $roomName }} which is booked for {{ $date }} from {{ $startTime }} to {{ $endTime }} by {{ Auth::user()->name }}.

	<br>

	<br>

	Thank you for using the Meeting Room Planner.</p>

</body>