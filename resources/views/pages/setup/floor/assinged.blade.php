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
                            <h4>Floor</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('building.index') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @php
                        $floor_building = $floor->first();
                        $building_name = $floor_building->first();
                    @endphp
                    <h4 class="cart-title text-center">{{ $building_name->building->name }}</h4>
                        <form action="{{ route('floor.store') }}" method="POST">
                            @csrf

                            @foreach ($floor as $key=>$floor)

                                <div class="card">
                                    <div class="card-header">
                                        <span class="float-left h5">{{ $key+1 }}<sup>st</sup> Floor </span>
                                        {{-- <button type="button" class="new_room1 btn btn-success float-right">Add a new room</button> --}}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            @foreach ($floor as $key1 =>$value)
                                                <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 individual_room">

                                                    {{-- Remove button  --}}
                                                    <button type="button" class="remove_room btn btn-sm btn-danger mb-3 float-right" onclick="removeRoom(this)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <input type="number" class="form-control mb-2" placeholder="Enter classroom number"  name="floor[{{$key}}][room][{{$key1}}][room_no]" value="{{$value->room_no}}" required>
                                                    <input type="number" class="form-control mb-2" placeholder="Enter total seat"  name="floor[{{$key}}][room][{{$key1}}][total_seat]" value="{{$value->total_seat}}">
                                                    <textarea class="form-control" cols="10" rows="3" placeholder="Enter classroom's details" name="floor[{{$key}}][room][{{$key1}}][room_details]">{{$value->room_details}}</textarea>
                                                </div>
                                                @php
                                                    $last_room = $key1+1;
                                                @endphp
                                            @endforeach

                                                {{-- Add new room button  --}}
                                            <div class="col-md-3  shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center">
                                                <button type="button" id="{{$last_room}}" floor="{{$key}}" class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $last_floor = $key+2;
                            @endphp
                            @endforeach

                                {{-- Add new floor button  --}}
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <span id="{{$last_floor}}" class="new_floor btn btn-success float-right mb-3">Add a new floor</span>
                                </div>
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

        //New room add
        function newRoomAdd(This){
        let room_index = $(This).attr('id');
            room_index = Number(room_index);
            $(This).attr('id',room_index+1)

        let floor_index = $(This).attr('floor');
            floor_index = Number(floor_index);

            let new_room = `
                            <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 individual_room">
                                <button type='button' class="remove_room btn btn-sm btn-danger mb-3 float-right" onclick="removeRoom(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                                <input type="number" class="form-control mb-2 input${floor_index}" placeholder="Enter classroom number"  name="floor[${floor_index}][room][${room_index}][room_no]" required>
                                @if ($errors->has('floor[${floor_index}][room][${room_index}][room_no]'))
                                    <span class="text-danger">{{ $errors->first('floor[${floor_index}][room][${room_index}][room_no]') }}</span>
                                @endif
                                <input type="number" class="form-control mb-2 input${floor_index}" placeholder="Enter total seat"  name="floor[${floor_index}][room][${room_index}][total_seat]">
                                <textarea class="form-control" cols="10" rows="3" placeholder="Enter classroom's details" name="floor[${floor_index}][room][${room_index}][room_details]"></textarea>
                            </div>
                    `;
                    $(new_room).insertBefore($(This).parent());

        }

        //Room remove
        function removeRoom(This){
            $(This).parent().remove();
        }

        $(document).ready(function() {
             //Add new floor
             $('.new_floor').click(function(){

                let floor_no = $(this).attr('id');
                $(this).attr('id',Number(floor_no)+1);
                let new_floor = `
                                <div class="card">
                                    <div class="card-header">
                                        <span class="float-left h5">${floor_no}<sup>st</sup> Floor </span>
                                        <button type="button" class="new_room1 btn btn-success float-right">Add a new room</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3  shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center">
                                                <button type="button" id="0"  class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>  `;
                $(new_floor).insertBefore($(this).parent().parent());
                });


            //copy code
            $('.total_room').each(function(index) {
                $(this).on('keyup change', function() {

                    var room_number = $(this).val();

                    $('.append').eq(index).empty();

                    if (room_number > 0) {
                        for (var i = 1; i <= room_number; i++) {
                            var individual_room = `
                                <div class="col shadow border rounded p-3 individual_room">
                                    <input type="number" class="form-control mb-2 input${index}" placeholder="Enter classroom number"  name="floor[${index}][room][${i}][room_no]" required>
                                    @if ($errors->has('floor[${index}][room][${i}][room_no]'))
                                        <span class="text-danger">{{ $errors->first('floor[${index}][room][${i}][room_no]') }}</span>
                                    @endif
                                    <input type="number" class="form-control mb-2 input${index}" placeholder="Enter total seat"  name="floor[${index}][room][${i}][seat_num]">
                                    <textarea class="form-control" cols="10" rows="3" placeholder="Enter classroom's details" name="floor[${index}][room][${i}][room_details]"></textarea>
                                </div>
                                `;
                            // $('.append').eq(index).append(individual_room);
                        }
                    }
                })

            });
        });

    </script>
@endpush
