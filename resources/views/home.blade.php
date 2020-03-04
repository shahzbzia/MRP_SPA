@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card table-responsive">
                <div class="card-header">{{ __('home.YOUR BOOKING HISTORY') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                    <table class="table">
            
                        <thead>
                            <th>{{ __('home.Image') }}</th>
                            <th>{{ __('home.User Name') }}</th>
                            <th>{{ __('home.Room Name') }}</th>
                            <th>{{ __('home.Created') }}</th>
                            <th>{{ __('home.Booking Date') }}</th>
                            <th>{{ __('home.Booking Time') }}</th>
                            <th>Extend / Cancel</th>
                        </thead>

                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                
                                <td><img src="{{ asset("storage/app/public/".$booking->room -> image) }}" width="50" height="50" ></td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->room->name }}</td>
                                <td>{{ $booking->created_at->diffForHumans() }}</td>
                                <td>{{ $booking->date }}</td>
                                <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                                <td>
                                    
                                    @if ($booking->user->id == Auth::user()->id)
                                        @if(\Carbon\Carbon::now('CET')->format('Y-m-dH:i:s') <= $booking->date.$booking->end_time)

                                        <a href="{{  route('editForm', [app()->getLocale(), $booking->id, $booking->room_id, $booking->date]) }}" class="btn btn-sm btn-dark"> Extend </a>


                                        <button class="btn btn-sm btn-dark" onclick="handleDelete({{ $booking->id }})"> Cancel </button>

                                        @else

                                            {{ __('bookings.Meeting Finished!') }}
                                            
                                        @endif
                                    @endif

                                </td>

                                {{-- {{  route('cancel', [app()->getLocale(), $booking->id]) }} --}}

                            @endforeach

                        </tbody>

                    </table>

                    <form action="" method="POST" id="cancelBookingForm">
                        @csrf

                        @method('Delete')
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Cancel Booking</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        This action is irreversible! Are you sure you want to cancel this booking?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    
    function handleDelete(id) {

        var form = document.getElementById('cancelBookingForm')

        form.action = '/cancel/' + id

        console.log('deleting...', form)

        $('#deleteModal').modal('show')
    }

</script>