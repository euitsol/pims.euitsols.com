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
                        <h4>Building Managment</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('building.index') }}"class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    <h4 class="cart-title text-center">
                        {{-- Building name input  --}}
                        <input type="text" id="building_name" placeholder="Enter building name"/>
                    </h4>
                    <form action="{{ route('floor.store') }}" method="POST">
                        @csrf
                        <div class="row text-center mb-3">
                            {{-- Floor name input  --}}
                            <input class="text-center m-auto"type="number" id="total_floor" placeholder="Enter total floor" hidden />
                        </div>

                        {{-- Floor append here when enter total floor  --}}
                        <div class="floor-append" id="floor_append"></div>

                        {{-- Add new floor button  --}}
                        <div class="card" id="new_floor" style="display: none !important">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <span id="0" class="new_floor btn btn-success float-right mb-3">Add a new floor</span>
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


        //Hide total input field
        function hiddenTotal(This, trind) {
            $("#total_floor").prop("disabled", true);
            $("#new_floor").prop("style", "block !important");
            $(This).parent().parent().parent().parent().children().children().children().prop("disabled", true);
            $(This).parent().parent().children(".new-room-col").css("display", "block");
        }

        //Room append according to total room
        function totalRoom(This) {
            let total_room = Number($(This).val());
            let floor = Number($(This).attr("floor"));

            let add_new_room_btn = $(This)
                .parent().parent().parent().children("div.card-body").children().children(".new-room-col");
            $(add_new_room_btn).prevAll().remove();
            $("#undo_info" + floor)
                .children()
                .empty();
            $("#undo_info" + floor).css("display", "none");
            if (total_room > 0) {
                for (let i = 1; i <= total_room; i++) {
                    let new_room = `
                            <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 individual_room" id="room${floor}${i}">
                                <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${i}</span>
                                <button type='button' class="remove_room btn btn-sm btn-danger mb-3 float-right" floor="${floor}" room="${i}"  id="remove${floor}${i}" onclick="removeRoom(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                                <input type="number" class="form-control mb-2 class_no${floor}" placeholder="Enter classroom number"  name="floor[${floor}][room][${i}][room_no]" onclick="hiddenTotal(this,${floor})" required>
                                @if ($errors->has('floor[${floor}][room][${i}][room_no]'))
                                    <span class="text-danger">{{ $errors->first('floor[${floor}][room][${i}][room_no]') }}</span>
                                @endif
                                <input type="number" class="form-control mb-2 total_seat${floor}" placeholder="Enter total seat"  name="floor[${floor}][room][${i}][total_seat]" onclick="hiddenTotal(this,${floor})">
                                <textarea class="form-control room_details${floor}" cols="10" rows="3" placeholder="Enter classroom's details" name="floor[${floor}][room][${i}][room_details]" onclick="hiddenTotal(this,${floor})"></textarea>
                            </div>
                            <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center delete-me" id="undo${floor}${i}" style="display: none !important">
                                <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${i}</span>
                                <button type="button" id="undo_input${floor}${i}" floor="${floor}" room="${i}"  class="undo btn btn-danger text-center" onclick="undo(this)">Undo</button>
                            </div>
                    `;

                    $(new_room).insertBefore(add_new_room_btn);
                    var room_index = i;
                }
                $(add_new_room_btn)
                    .children()
                    .attr("id", room_index + 1);
                $(add_new_room_btn)
                    .children()
                    .attr("room", room_index + 1);
            }
        }
        //New room add
        function newRoomAdd(This) {
            let floor = Number($(This).attr("floor"));
            let room = Number($(This).attr("room"));

            $(This).attr("room", room + 1);

            let new_room = `
                                <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 individual_room" id="room${floor}${room}">
                                    <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${room}</span>
                                    <button type='button' class="remove_room btn btn-sm btn-danger mb-3 float-right" floor="${floor}" room="${room}" id="remove${floor}${room}" onclick="removeRoom(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="number" class="form-control mb-2" placeholder="Enter classroom number"  name="floor[${floor}][room][${room}][room_no]" onclick="hiddenTotal(this,${floor})" required>
                                    @if ($errors->has('floor[${floor}][room][${room}][room_no]'))
                                        <span class="text-danger">{{ $errors->first('floor[${floor}][room][${room}][room_no]') }}</span>
                                    @endif
                                    <input type="number" class="form-control mb-2" placeholder="Enter total seat"  name="floor[${floor}][room][${room}][total_seat]" onclick="hiddenTotal(this,${floor})">
                                    <textarea class="form-control" cols="10" rows="3" placeholder="Enter classroom's details" name="floor[${floor}][room][${room}][room_details]" onclick="hiddenTotal(this,${floor})"></textarea>
                                </div>
                                <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center delete-me" id="undo${floor}${room}" style="display: none !important">
                                <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${room}</span>
                                <button type="button" id="undo_input${floor}${room}" floor="${floor}" room="${room}"  class="undo btn btn-danger text-center" onclick="undo(this)">Undo</button>
                            </div>
                        `;
            $(new_room).insertBefore($(This).parent());
            let total_room_access = $(This)
                .parent()
                .parent()
                .parent()
                .parent()
                .children(".card-header")
                .children(".float-right")
                .children();
            total_room_access.val(Number($(total_room_access).val()) + 1);
        }

        //Room remove
        function removeRoom(This) {
            let floor = $(This).attr("floor");
            let room = $(This).attr("room");
            var floor_room = floor + room;

            $("#room" + floor_room).attr("hidden", true);
            $("#undo" + floor_room).css("display", "block");
            $("#total_room" + floor).val(
                Number($("#total_room" + floor).val()) - 1
            );
            $("#undo_info" + floor).css("display", "block");
            $("#undo_info" + floor)
                .children()
                .html(
                    Number(
                        $("#undo_info" + floor)
                            .children()
                            .html()
                    ) + 1
                );
            $("#room" + floor_room).addClass("delete-me");

            // $(This).parent().remove();
        }

        //Undo function
        function undo(This) {
            let floor = $(This).attr("floor");
            let room = $(This).attr("room");
            let floor_room = floor + room;
            $("#undo" + floor_room).attr("style", "display: none !important;");
            $("#room" + floor_room).attr("hidden", false);
            $("#room" + floor_room).removeClass("delete-me");
            $("#undo_info" + floor)
                .children()
                .html(
                    Number(
                        $("#undo_info" + floor)
                            .children()
                            .html()
                    ) - 1
                );
            $("#total_room" + floor).val(
                Number($("#total_room" + floor).val()) + 1
            );
            if (
                Number(
                    $("#undo_info" + floor)
                        .children()
                        .html()
                ) < 1
            ) {
                $("#undo_info" + floor).attr("style", "display: none !important;");
            }
        }

        //Docuemnt.ready function
        $(document).ready(function () {
            // show total floor input feild
            $("#building_name").on("keyup", function () {
                if ($(this).val().length > 4) {
                    $("#total_floor").prop("hidden", false);
                }
            });

            //floor add according to total floor
            $("#total_floor").on("keyup", function () {
                let total_floor = Number($(this).val());
                $("#new_floor").children().children().attr("id", total_floor+1);
                $(".submit-btn").prop("hidden", true);
                $("#floor_append").empty();
                if (total_floor > 0) {
                    $(".submit-btn").prop("hidden", false);

                    for (let i = 1; i <= total_floor; i++) {
                        let new_floor = `<div class="card">
                                            <div class="card-header">
                                                <span class="float-left h5">${i}<sup>st</sup> Floor </span>
                                                <span class="float-right">
                                                    <input type='number' class="total-room" name='total_room' placeholder="Enter total room" floor="${i}"  id='total_room${i}' onkeyup='totalRoom(this)'>
                                                    <span class="text-danger" id='undo_info${i}' style="display:none">Removed: <span></span></span>
                                                </span>
                                            </div>
                                            <div class="card-body" id='checkno'>
                                                <div class="row">
                                                    <div class="col-md-3 new-room-col shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center" style='display: none !important'>
                                                        <button type="button" id="0" floor="${i}" room='0'  class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  `;

                        $("#floor_append").append(new_floor);
                    }
                }
            });

            //Add new floor
            $(".new_floor").click(function () {
                let floor_no = Number($(this).attr("id")) + 1;
                $(this).attr("id", floor_no);
                let new_floor = `<div class="card">
                                    <div class="card-header">
                                        <span class="float-left h5">${floor_no}<sup>st</sup> Floor </span>
                                        <span class="float-right">
                                            <input type='number' name='total room' placeholder="Enter total room" floor="${floor_no}"  id='total_room${floor_no}' onkeyup='totalRoom(this)'>
                                            <span class="text-danger" id='undo_info${floor_no}' style="display:none">Removed: <span></span></span>
                                        </span>
                                    </div>
                                    <div class="card-body" id='checkno'>
                                        <div class="row">
                                            <div class="col-md-3 new-room-col shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center" style='display: none !important'>
                                                <button type="button" id="0" floor="${floor_no}" room="0"  class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>  `;
                $(new_floor).insertBefore($(this).parent().parent());
                $("#total_floor").val(Number($("#total_floor").val()) + 1);
            });
        });
    </script>
@endpush
