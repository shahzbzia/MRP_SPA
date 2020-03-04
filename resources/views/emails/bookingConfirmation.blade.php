@component('mail::message')
# Thank you for using the Meeting Room Planner

@if ($linkedUsers === null)
	
Room: "{{ $roomName }}" is booked by {{ $to_name }} for {{ $date }} from {{ $startTime }} to {{ $endTime }}.

@else

Room: "{{ $roomName }}" is booked by {{ $to_name }} for {{ $date }} from {{ $startTime }} to {{ $endTime }} with the following linked users: {{ $linkedUsers }}.

@endif

<br>

@component('mail::button', ['url' => config('app.url') . app()->getLocale(). '/dashboard'])
Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
