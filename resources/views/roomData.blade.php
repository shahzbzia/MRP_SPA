<div class="row" id="ads">
    @foreach ($rooms as $room)
        <div @if ($room->count() < 2) class="col-md-6 customPadding" @else class="col-md-4 customPadding" @endif >
            <div class="card rounded h-100 w-100">
                <a class="noDecor" href=" {{ route('bookings.create', [app()->getLocale(), $room->id]) }}">
                    <div class="card-image">
                        <img class="img-fluid" src="{{ asset("storage/app/public/".$room -> image) }}"> {{-- asset("storage/app/public/".$room -> image) --}}
                    </div>
                
                    <div class="card-body text-center d-flex flex-column customCss">
                        <span class="card-header-tabs text-center pl-2 pr-2 noDecor">{{ $room->name }}</span>
                        <span class="card-header-tabs text-center mt-2 pl-2 pr-2 smallText">{{ $room->location }}</span>
                        <span class="card-header-tabs text-center mt-2 pl-2 pr-2 smallText pb-3">{{ $room->description }}</span>
                        <span class="card-header-tabs text-center mt-2 pl-2 pr-2 smallText grayColor">
                                
                            @foreach($room->booking as $b)

                                @if (\Carbon\Carbon::now('CET')->format('Y-m-d') == $b->date)
                                    
                                    @if (\Carbon\Carbon::now('CET')->format('H:i:s') <= $b->end_time && \Carbon\Carbon::now('CET')->format('H:i:s') >= $b->start_time)                                           

                                        <div @if ($loop->first) class="hidden" @endif>

                                            Current Meeting: {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($b->end_time)->format('H:i') }} <br>

                                        </div>

                                        @break
                                    
                                    @endif

                                    @if (\Carbon\Carbon::now('CET')->format('H:i:s') < $b->start_time)

                                        <div @if ($loop->first) class="hidden" @endif>

                                            Next Meeting: {{ \Carbon\Carbon::parse($b->start_time)->format('H:i'). ' - ' . \Carbon\Carbon::parse($b->end_time)->format('H:i') }}

                                        </div> 

                                        @break

                                    @endif

                                @endif

                            @endforeach

                        </span>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
</div>