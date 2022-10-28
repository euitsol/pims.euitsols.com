@extends('layouts.app')

@section('title', 'Floor Management')

@push('third_party_stylesheets')
@endpush

@push('page_css')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4> Add class room</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('building.index') }}" class="btn btn-info">Back</a>

                        </span>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center">{{ $building->name }}</h4>
                        <form action="{{ route('floor.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="building_id" value="{{ $building->id }}">
                            @if ($building)
                                @for ($i = 1; $i <= $building->floor; $i++)
                                    <div class="card">
                                        <div class="card-header">
                                            <span class="float-left">{{ $i }}<sup>st</sup> Floor </span>
                                            <span class="float-right">
                                                <label for="total_room">Total room:</label>
                                                <input type="number" id="total_room"
                                                    class="from-control border-primary total_room" step="1"
                                                    placeholder="Enter Total class room"
                                                    name="floor[{{ $i - 1 }}][total_room]"></span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row row-cols-3 append">

                                            </div>
                                        </div>
                                    </div>
                                @endfor

                            @endif

                            {{-- Class room append here --}}
                            <div class="row row-cols-3 mt-3" id="append">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 mt-2 submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('third_party_scripts')
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.total_room').each(function(index) {
                $(this).on('keyup', function() {

                    var room_number = $(this).val();

                    $('.append').eq(index).empty();

                    if (room_number > 0) {
                        for (var i = 1; i <= room_number; i++) {
                            var individual_room = `
                                <div class="col shadow border rounded p-3 individual_room">
                                    <input type="number" class="form-control mb-2 input${index}" placeholder="Enter class room number"  name="floor[${index}][room][${i}][room_no]" required>
                                    @if ($errors->has('floor[${index}][room][${i}][room_no]'))
                                        <span class="text-danger">{{ $errors->first('floor[${index}][room][${i}][room_no]') }}</span>
                                    @endif
                                    <input type="number" class="form-control mb-2 input${index}" placeholder="Enter Seat number"  name="floor[${index}][room][${i}][seat_num]">
                                    <textarea class="form-control" cols="10" rows="3" placeholder="Enter class room's details" name="floor[${index}][room][${i}][room_details]"></textarea>
                                </div>
                                `;
                            $('.append').eq(index).append(individual_room);
                        }

                        //Subbimt button add
                        // $('.append').eq(index).append(`<div class="col-12">
                    //         <button class="btn btn-primary w-100 mt-2 submit-btn">Submit</button>
                    //     </div>`);
                    }
                })

            });
        });

    </script>
@endpush
