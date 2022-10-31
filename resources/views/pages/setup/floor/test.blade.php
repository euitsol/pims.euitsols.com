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

                        <h4 class="cart-title text-center">
                            {{-- Building name input  --}}
                            <input type="text" id="building_name" placeholder="Enter building name">
                        </h4>
                        <form action="{{ route('floor.store') }}" method="POST">
                            @csrf
                            <div class="row text-center mb-3">
                                {{-- Floor name input  --}}
                                <input class="text-center m-auto " type="number" class="" id="total_floor" hidden>
                            </div>

                            {{-- Floor append here when enter total floor  --}}
                            <div class="floor-append" id="floor_append">

                            </div>

                            {{-- Add new floor button  --}}
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <span id="0" class="new_floor btn btn-success float-right mb-3" hidden>Add a new floor</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100 mt-2 submit-btn" hidden>Submit</button>
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
        //change new floor id
        $('#total_floor').on('keyup',function(){
            $(".new_floor").attr('id',$(this).val());
        });

        //change new room id
        $('#total_floor').on('keyup',function(){
            $(".new_floor").attr('id',$(this).val());
        });

        //Hide total input field
        function hiddenTotal(This,trind){
            $("#total_floor").prop('disabled',true);
            $(".new_floor").prop('hidden',false);
            // $('.new-room-col').eq(trind-1).css('display','block');
            // $('.total-room').eq(trind-1).prop('disabled',true);
            $(This).parent().parent().parent().parent().children().children().children().prop('disabled',true);
            $(This).parent().parent().children('.new-room-col').css('display','block');
        }

        //Room append according to total room
        function totalRoom(This){
            let total_room = $(This).val();
            total_room = Number(total_room);
            let floor_index = $(This).attr('id');

            let add_new_room_btn = $(This).parent().parent().parent().children("div.card-body").children().children('.new-room-col');
            $(add_new_room_btn).prevAll().remove();
            if(total_room>0){

                for(let i = 1; i<=total_room;i++){
                    let new_room = `
                        <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 individual_room">
                            <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${i}</span>
                            <button type='button' class="remove_room btn btn-sm btn-danger mb-3 float-right" onclick="removeRoom(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <input type="number" class="form-control mb-2 class_no${floor_index}" placeholder="Enter classroom number"  name="floor[${floor_index}][room][${i}][room_no]" onclick="hiddenTotal(this,${floor_index})" required>
                            @if ($errors->has('floor[${floor_index}][room][${i}][room_no]'))
                                <span class="text-danger">{{ $errors->first('floor[${floor_index}][room][${i}][room_no]') }}</span>
                            @endif
                            <input type="number" class="form-control mb-2 total_seat${floor_index}" placeholder="Enter total seat"  name="floor[${floor_index}][room][${i}][total_seat]" onclick="hiddenTotal(this,${floor_index})">
                            <textarea class="form-control room_details${floor_index}" cols="10" rows="3" placeholder="Enter classroom's details" name="floor[${floor_index}][room][${i}][room_details]" onclick="hiddenTotal(this,${floor_index})"></textarea>
                        </div>
                `;

                $(new_room).insertBefore(add_new_room_btn);
                var room_index = i
            }
            $(add_new_room_btn).children().attr('id',room_index+1);
            }
        }
        //New room add
        function newRoomAdd(This){
        let room_index = Number($(This).attr('id'));

            $(This).attr('id',room_index+1)

        let floor_index = Number($(This).attr('floor'));

            let new_room = `
                            <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 individual_room">
                                <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${room_index}</span>
                                <button type='button' class="remove_room btn btn-sm btn-danger mb-3 float-right" onclick="removeRoom(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                                <input type="number" class="form-control mb-2 input${floor_index}" placeholder="Enter classroom number"  name="floor[${floor_index}][room][${room_index}][room_no]" onclick="hiddenTotal(this,${floor_index})" required>
                                @if ($errors->has('floor[${floor_index}][room][${room_index}][room_no]'))
                                    <span class="text-danger">{{ $errors->first('floor[${floor_index}][room][${room_index}][room_no]') }}</span>
                                @endif
                                <input type="number" class="form-control mb-2 input${floor_index}" placeholder="Enter total seat"  name="floor[${floor_index}][room][${room_index}][total_seat]" onclick="hiddenTotal(this,${floor_index})">
                                <textarea class="form-control" cols="10" rows="3" placeholder="Enter classroom's details" name="floor[${floor_index}][room][${room_index}][room_details]" onclick="hiddenTotal(this,${floor_index})"></textarea>
                            </div>
                    `;
                    $(new_room).insertBefore($(This).parent());

        }

        //Room remove
        function removeRoom(This){
            $(This).parent().remove();
        }

        //Docuemnt.ready function
        $(document).ready(function() {

            // show total floor input feild
            $('#building_name').on('keyup',function(){
                if($(this).val().length>4){
                    $('#total_floor').prop('hidden',false);
                }
            });

            //floor add according to total room
            $('#total_floor').on('keyup',function(){
                let total_floor = $(this).val();
                total_floor = Number(total_floor);
                $('#floor_append').empty();
                if(total_floor>0){
                    $('.submit-btn').prop('hidden',false);

                for(let i = 1; i<=total_floor;i++){
                    let new_floor = `
                                <div class="card">
                                    <div class="card-header">
                                        <span class="float-left h5">${i}<sup>st</sup> Floor </span>
                                        <span class="float-right">
                                            <input type='number' class="total-room" name='total_room' palaceholder='Enter total room number' id='${i}' onkeyup='totalRoom(this)'>
                                        </span>
                                    </div>
                                    <div class="card-body" id='checkno'>
                                        <div class="row">
                                            <div class="col-md-3 new-room-col shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center" style='display: none !important'>
                                                <button type="button" id="0" floor="${i}"  class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>  `;

                                $('#floor_append').append(new_floor);
                    // $(new_floor).insertAfter($(this).parent());
                }
            }
            });

             //Add new floor
             $('.new_floor').click(function(){

                let floor_no = Number($(this).attr('id'))+1;
                    $(this).attr('id',floor_no);
                let new_floor = `
                                <div class="card">
                                    <div class="card-header">
                                        <span class="float-left h5">${floor_no}<sup>st</sup> Floor </span>
                                        <span class="float-right">
                                            <input type='number' name='total room' palaceholder='Enter total room number' id='total_room' onkeyup='totalRoom(this)'>
                                        </span>
                                    </div>
                                    <div class="card-body" id='checkno'>
                                        <div class="row">
                                            <div class="col-md-3 new-room-col shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center" style='display: none !important'>
                                                <button type="button" id="0" floor="${floor_no}"  class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
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
