@extends('layouts.app')
@section('title', 'Building Management')

@push('third_party_stylesheets')
@endpush

@push('page_css')
<style>
    .custom-badge{
        top: 2px;
        left: 2px;
        font-size: 15px;
    }
    .card-header::after{
        display: none;
    }
    .spinner-border-sm {
    width: 22px !important;
    height: 22px !important;
    border-width: 0.2em;
}
#check_name{
    top: 7px;
    right: 38%;
}
#check_name span{
    display: none;
}
#check_name i#wrong{
    font-size: 24px;
    color: #f70909;
    display: none;
}
#check_name i#right{
    font-size: 23px;
    color: green;
    display: none;
}
</style>
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
                    <form action="{{ route('building.store') }}" method="POST">
                        @csrf
                        {{-- Building name input  --}}

                        <div class="cart-title text-center mb-2 position-relative">
                            <input type="text" name="building_name" id="building_name" class="form-control w-25 m-auto text-center" placeholder="Enter building name" step="0"/>
                            <div id="check_name" class="position-absolute">
                                <span id="spinner" class="custom-spinner spinner-border spinner-border-sm text-primary"></span>
                                <i id="right" class="fas fa-check-circle"></i>
                                <i id="wrong" class="fas fa-times-circle"></i>
                            </div>
                        </div>

                        {{-- Floor name input  --}}
                        <div class="mb-3 margin-left text-center">
                            <input name="total_floor"  class="text-center form-control w-25 m-auto" type="number" id="total_floor" placeholder="Enter total floor" step="0"  />
                            <span class="text-danger m-auto" style="display: none">Removed: <span id="removed_floor_info"></span></span>
                        </div>
                       <div class="text-center mb-3">
                        <button type="button" id="show_floor" class="btn btn-success ">Show floor</button>
                       </div>

                        {{-- Floor append here when enter total floor  --}}
                        <div class="floor-append" id="floor_append"></div>

                        {{-- Add new floor button  --}}
                        <div class="card" id="new_floor" style="display: none !important">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <span id="0" class="new_floor btn btn-success float-right mb-3">Add a new floor</span>
                            </div>
                        </div>

                        <div class="col-12" id="submit_button">
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
            let floor = $(This).attr('data-floor');

            $("#show_floor").attr("style", "display: none;");
            $("#total_floor").prop("readonly", true);
            $("#new_floor").prop("style", "display: block !important;");
            $("#floor"+floor).find('.total-room').prop("readonly", true);
            $(This).parent().parent().children(".new-room-col").css("display", "block");
        }

        //Room append according to total room
        function totalRoom(This) {
            let total_room = Number($(This).val());
            let floor = Number($(This).attr("data-floor"));
            console.log(floor);
            let add_new_room_btn = $("#floor"+floor).find('.new-room-col');
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
                                <button type='button' class="remove_room btn btn-sm btn-danger mb-3 float-right" data-floor="${floor}" data-room="${i}"  id="remove${floor}${i}" onclick="removeRoom(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                                <input type="number" step="0" class="room_number form-control mb-2 class_no${floor}" placeholder="Enter room number" data-floor="${floor}" data-room="${i}" name="floor[${floor}][room][${i}][room_no]" onkeyup="hiddenTotal(this,${floor})" onfocusout="checkRoomNum(this)" value='${floor*100+i}' required>
                                <input type="text" class="room_number form-control mb-2 room_name${floor}" placeholder="Enter room name" data-floor="${floor}" data-room="${i}" name="floor[${floor}][room][${i}][room_name]" onkeyup="hiddenTotal(this,${floor})">
                                <input type="number" step="0" class="form-control mb-2 total_seat${floor}" placeholder="Enter total seat" data-floor="${floor}" data-room="${i}"  name="floor[${floor}][room][${i}][total_seat]" onkeyup="hiddenTotal(this,${floor})">
                                <textarea class="form-control room_details${floor}" cols="10" rows="3" placeholder="Enter room's details" data-floor="${floor}" data-room="${i}" name="floor[${floor}][room][${i}][room_details]" onkeyup="hiddenTotal(this,${floor})"></textarea>
                            </div>
                            <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center delete-me" id="undo${floor}${i}" style="display: none !important">
                                <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${i}</span>
                                <button type="button" id="undo_input${floor}${i}" data-floor="${floor}" data-room="${i}"  class="undo btn btn-danger text-center" onclick="undo(this)">Undo</button>
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
                    .attr("data-room", room_index + 1);
            }
        }
        //New room add
        function newRoomAdd(This) {
            let floor = Number($(This).attr("data-floor"));
            let room = Number($(This).attr("data-room"));

            $(This).attr("data-room", room + 1);

            let new_room = `
                                <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 individual_room" id="room${floor}${room}">
                                    <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${room}</span>
                                    <button type='button' class="remove_room btn btn-sm btn-danger mb-3 float-right" data-floor="${floor}" data-room="${room}" id="remove${floor}${room}" onclick="removeRoom(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="number" step="0" class="room_number form-control mb-2" placeholder="Enter room number" data-floor="${floor}" data-room="${room}"  name="floor[${floor}][room][${room}][room_no]" onkeyup="hiddenTotal(this,${floor})" onfocusout="checkRoomNum(this)" value='${floor*100+room}' required>
                                    <input type="text" class="room_name form-control mb-2" placeholder="Enter room name" data-floor="${floor}" data-room="${room}"  name="floor[${floor}][room][${room}][room_name]" onkeyup="hiddenTotal(this,${floor})">
                                    <input type="number" step="0" class="form-control mb-2" placeholder="Enter total seat" data-floor="${floor}" data-room="${room}"  name="floor[${floor}][room][${room}][total_seat]" onkeyup="hiddenTotal(this,${floor})">
                                    <textarea class="form-control" cols="10" rows="3" placeholder="Enter room's details" data-floor="${floor}" data-room="${room}" name="floor[${floor}][room][${room}][room_details]" onkeyup="hiddenTotal(this,${floor})"></textarea>
                                </div>
                                <div class="col-md-3 shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center delete-me" id="undo${floor}${room}" style="display: none !important">
                                <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 start-0" style='left: 2px;top: 4px;'>${room}</span>
                                <button type="button" id="undo_input${floor}${room}" data-floor="${floor}" data-room="${room}"  class="undo btn btn-danger text-center" onclick="undo(this)">Undo</button>
                            </div>
                        `;
            $(new_room).insertBefore($(This).parent());
            let total_room_access = $("#floor"+floor).find('.total-room');
            total_room_access.val(Number($(total_room_access).val()) + 1);
        }

        //Room Number Check
        function checkRoomNum(This){
           let room_no = $(This).val();
           $(This).removeClass('room_number');
           var err_check = 0;
           $(".room_number").each(function(index){
               if(room_no>0){
                if(room_no == $(this).val()){
                    $(This).next('span').remove();
                    $(`<span class='text-danger mb-2'>Room number ${room_no} exists in the floor ${$(this).attr('data-floor')}</span>`).insertAfter($(This));
                    $(This).attr('style','background: #fce4e4;');
                    err_check = 1
                }
               }
           });
           if(err_check == 0){
            $(This).attr('style','background: inherit;');
            $(This).next('span').remove();
           }
           $(This).addClass('room_number');
        }

        //Room remove
        function removeRoom(This) {
            let floor = $(This).attr("data-floor");
            let room = $(This).attr("data-room");
            var floor_room = floor + room;

            $("#room" + floor_room).attr("hidden", true);
            $("#room" + floor_room).find("input,textarea").attr("disabled", true);
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
            let floor = $(This).attr("data-floor");
            let room = $(This).attr("data-room");
            let floor_room = floor + room;
            $("#undo" + floor_room).attr("style", "display: none !important;");
            $("#room" + floor_room).attr("hidden", false);
            $("#room" + floor_room).find("input,textarea").attr("disabled", false);
            $("#undo_info" + floor).children().html(Number($("#undo_info" + floor).children().html()) - 1);
            $("#total_room" + floor).val(Number($("#total_room" + floor).val()) + 1);
            if (Number($("#undo_info" + floor).children().html()) < 1) {
                $("#undo_info" + floor).attr("style", "display: none !important;");
            }
        }

        function floorRemove(This){
            let floor = $(This).attr('data-floor');
            $('#floor'+floor).css('display','none');
            $('#floor'+floor).find("input").prop('disabled',true);
            $('#undo_floor'+floor).css('display','block');
            $("#total_floor").val(Number($("#total_floor").val()) - 1);

            $("#removed_floor_info").parent().css('display','inline-block');
            $("#removed_floor_info").html(Number($("#removed_floor_info").html())+1);

            if(Number($("#total_floor").val())<1){
                $("#submit_button").css('display','none');
            }
        }


        function floorUndo(This){
            let floor = $(This).attr('data-floor');
            $('#undo_floor'+floor).css('display','none');
            $('#floor'+floor).css('display','block');
            $('#floor'+floor).find("input").prop('disabled',false);
            $("#total_floor").val(Number($("#total_floor").val()) + 1);
            $("#removed_floor_info").html(Number($("#removed_floor_info").html())-1);
            $("#submit_button").css('display','block');

            if(Number($("#removed_floor_info").html())<1){
                $("#removed_floor_info").parent().css('display','none');
            }
        }

        //Docuemnt.ready function
        $(document).ready(function () {

            $("#building_name").on('keyup',function () {

                $(this).next('div#check_name').children('span#spinner').css('display','none');
                $(this).next('div#check_name').children('i').css('display','none');
                $("#check_name").children('i#wrong').css('display','none');
                $("#building_name").attr('style','background: inherit;')

                if($(this).val() !== ''){
                    $(this).next('div#check_name').children('span#spinner').css('display','block');
                    var building_name = $(this).val();
                }else{
                    return false;
                }

                $.ajax({
                    type: "get",
                    url: "{{route('building.name_check')}}",
                    data: {
                        name:building_name
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if(response ===1){
                            $("#check_name").children('span#spinner').css('display','none');
                            $("#check_name").children('i#wrong').css('display','none');
                            $("#building_name").attr('style','background: inherit;')
                            $("#check_name").children('i#right').css('display','block');
                            $("#show_floor").css('display','inline-block');
                        }else{
                            $("#check_name").children('span#spinner').css('display','none');
                            $("#check_name").children('i#right').css('display','none');
                            $("#show_floor").css('display','none');
                            $("#check_name").children('i#wrong').css('display','block');
                            $("#building_name").attr('style','background: #fce4e4;')
                        }
                    }
                });
             });

            $('#total_floor').on('keyup change',function(){
                $("#show_floor").addClass('btn-success');
            });

            //floor add according to total floor
            $("#show_floor").on("click", function () {

                $("#total_floor").val(Math.round($("#total_floor").val()));
                if(!$("#building_name").val()){
                    $('#building_name').next('span').remove();
                    $("<span class='text-danger mb-2'>Enter Building Name</span>").insertAfter($("#building_name"));
                    return false;
                }else{
                    $('#building_name').next('span').remove();
                }

                if(!$("#total_floor").val()){
                    $('#total_floor').next('span').remove();
                    $("<span class='text-danger'>Enter total floor</span>").insertAfter($("#total_floor"));
                    return false;
                }else{
                    $('#total_floor').next('span').remove();
                }

                let total_floor = Number($("#total_floor").val());
                $("#new_floor").children().children().attr("id", total_floor+1);
                $(".submit-btn").prop("hidden", true);
                $("#floor_append").empty();
                if (total_floor > 0) {
                    $(".submit-btn").prop("hidden", false);

                    for (let i = 1; i <= total_floor; i++) {
                        let new_floor = `<div class="card" id="floor${i}">
                                            <div class="card-header d-flex justify-content-between w-100">
                                                <div class="text-center">
                                                    <input type='number' step="0" class="total-room form-control" name='floor[${i}][total_room]' placeholder="Enter total room" data-floor="${i}"  id='total_room${i}' onkeyup='totalRoom(this)'>
                                                    <span class="text-danger" id='undo_info${i}' style="display:none">Removed: <span></span></span>
                                                </div>
                                                <span class="h4 pt-1">Floor-${i}</span>
                                                <button type='button' class="btn btn-sm bg-danger float-md-left" onclick="floorRemove(this)" data-floor="${i}">Remove</button>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 new-room-col shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center" style='display: none !important'>
                                                        <button type="button" id="0" data-floor="${i}" data-room='0'  class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" id="undo_floor${i}" style="display: none;">
                                            <div class="card-body text-center">
                                                <button type="button" id="undo${i}" data-floor="${i}"  class="btn btn-danger text-center" onclick="floorUndo(this)">Undo the Floor ${i}</button>
                                            </div>
                                        </div> `;

                        $("#floor_append").append(new_floor);
                    }
                }
                $(this).removeClass('btn-success');
                $(this).addClass('border-success');
            });

            //Add new floor
            $(".new_floor").click(function () {
                let floor = Number($(this).attr("id"));
                $(this).attr("id", floor+1);
                let new_floor = `<div class="card" id="floor${floor}">
                                    <div class="card-header d-flex justify-content-between w-100">
                                        <div class='text-center'>
                                            <input type='number' step="0" class="total-room form-control" name='floor[${floor}][total_room]' placeholder="Enter total room" data-floor="${floor}"  id='total_room${floor}' onkeyup='totalRoom(this)'>
                                            <span class="text-danger" id='undo_info${floor}' style="display:none">Removed: <span></span></span>
                                        </div>
                                        <span class=" h5">Floor-${floor} </span>
                                        <button type='button' class="btn btn-sm bg-danger" data-floor="${floor}" onclick="floorRemove(this)">Remove</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 new-room-col shadow border border-5 border-secondary rounded p-3 d-flex align-items-center justify-content-center" style='display: none !important'>
                                                <button type="button" id="0" data-floor="${floor}" data-room="0"  class="new_room btn btn-success text-center" onclick="newRoomAdd(this)">Add a new room</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="undo_floor${floor}" style="display: none;">
                                    <div class="card-body text-center">
                                        <button type="button" id="undo${floor}" data-floor="${floor}"  class="btn btn-danger text-center" onclick="floorUndo(this)">Undo the Floor ${floor}</button>
                                    </div>
                                </div> `;
                $(new_floor).insertBefore($(this).parent().parent());
                $("#total_floor").val(Number($("#total_floor").val()) + 1);
            });
        });
    </script>
@endpush
