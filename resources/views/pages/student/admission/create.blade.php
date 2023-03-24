@extends('layouts.app')

@section('title', 'Admit Student')

@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/filepond/filepond-plugin-image-preview.css') }}">

@endpush

@push('page_css')
    <style>
        .step {
            display: inline-block;
            height: 30px;
            width: 30px;
            background: green;
            color: white;
            border-radius: 50%;
            line-height: 30px;
            margin: 0px 2px;
            opacity: 0.25;
        }
        .floating-cart {
            position: fixed;
            width: 55px;
            height: 55px;
            bottom: 36%;
            right: 5.3%;
            background-color: blue;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            cursor: pointer;
            z-index: 1;
            transition: 2s;
        }
        .floating-cart i {
            line-height: 3.2rem;
            font-size: 23px;
        }
        .select2-container {
            width: 100% !important;
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
                            <h4>Add {{ $page_name }}</h4>
                        </span>
                        <span class="float-right">
                        </span>
                    </div>
                    <div class="card-body">
                        @include("partial.flush-message")
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <h2 class="text-center">Admission Form</h2>
                                <div align='center'>
                                    <span class="step" id="step-1" style="opacity: 1">1</span>
                                    <span class="step" id="step-2">2</span>
                                    <span class="step" id="step-3">3</span>
                                </div>

                                <form action="{{ route('student.student-admit.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    <div class="tab" id="tab-1" style="display: block">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                        <fieldset>
                                            <h2 class="text-center">Department Choice</h2>
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                    <label for="departments_id">Department Name:<span
                                                        class="text-danger">*</span> </label>
                                                </div>
                                                <div class="col-md-6 text-left">
                                                    <div class="form-group">
                                                        <select id="departments_id" class="select form-control form-validation"
                                                            name="departments_id" required>
                                                            <option value="" hidden>Select Department</option>
                                                            @foreach ($department as $n)
                                                            <option value="{{$n->id}}" @if( old('departments_id') == $n->id) selected @endif>{{$n->department_name.' ('.$n->short_name.')'}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <button type="button" class="next btn btn-success"
                                                    onclick="next(1)">Next</button>
                                            </div>
                                        </fieldset>
                                    </div>

                                    {{-- Personal data  --}}
                                    <div class="tab Personal-data" id="tab-2" style="display: none">
                                        <fieldset class="shadow-lg p-3 mb-5 bg-body rounded">
                                            <h2 class="text-center">Personal data</h2>
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Full Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('name') }}"  type="text" id="name"
                                                            name="name" placeholder="Enter Full Name" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="father_name">Father's Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('father_name') }}"  type="text" id="father_name"
                                                            name="father_name" placeholder="Enter Father's Name"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="mother_name">Mother's Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('mother_name') }}"  type="text"
                                                            name="mother_name" placeholder="Enter Mother's Name" id="mother_name"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="email">Email address: </label>
                                                        <input type="email" value="{{ old('email') }}" name="email" id="email"
                                                            class="form-control" placeholder="Email Address" >
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone">Phone: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('phone') }}"  type="number" maxlength="11" minlength="11" id="phone"
                                                            name="phone" class="form-control" placeholder="Enter Phone Number" onfocusout="phoneNumberChk()" required>
                                                        <span id="phn">Phone number be must be 11 digits</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gardian_phone">Guardian Phone:<span class="text-danger">*</span>    </label>
                                                        <input value="{{ old('gardian_phone') }}" type="number" maxlength="11" minlength="11" id="gardian_phone"
                                                            name="gardian_phone" class="form-control" placeholder="Guardian Phone Number" onfocusout="phoneNumberChk()" required>

                                                        <span id="guardphn">Phone number be must be 11 digits</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gender">Gender: <span
                                                                class="text-danger">*</span></label>
                                                        <select class="select form-control"  name="gender" id="gender" required>
                                                            <option value="" hidden>Select Gender</option>
                                                            <option value="Male" @if( old('gender') == "Male") selected @endif >Male</option>
                                                            <option value="Female" @if( old('gender') == "Female") selected @endif> Female</option>
                                                            <option value="Other" @if( old('gender') == "Other") selected @endif> Other</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="dob">Date of Birth:<span class="text-danger">*</span></label>
                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                            <input type="text" name="dob" class="form-control datetimepicker-input date" data-target="#reservationdate" id="dob" value="{{ old('dob') }}" required>
                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nationality">Nationality: <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="nationality" value="{{ old('nationality') }}" id="nationality"
                                                             class="form-control date-pick" placeholder="Enter Nationality" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bg_id">Blood Group: <span class="text-danger">*</span></label>
                                                        <select class="select form-control"  name="bg_id" id="bg_id" required>
                                                            <option value="" hidden>Select Blood Group</option>
                                                            @foreach ($bg as $n)
                                                            <option value="{{$n->id}}" @if( old('bg_id') == $n->id) selected @endif>{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label id="quota">Quota</label>
                                                        <input name="quota" value="{{ old('quota') }}" type="text" id="quota"
                                                            class="form-control" placeholder="Enter quota if available">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="division">Your Division: <span class="text-danger">*</span></label>
                                                        <select id="division" class="select form-control form-validation"  name="division_id" required>
                                                            <option value="0" selected>Select Your Division</option>
                                                            @foreach ($division as $n)
                                                            <option value="{{$n->id}}" @if( old('division_id') == $n->id) selected @endif>{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="district">Your District: <span class="text-danger">*</span></label>
                                                        <select id="district" class="select form-control"  name="district_id" disabled required>
                                                            <option value="" hidden>Select Your District</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="present_address">Present Address: <span class="text-danger">*</span></label>
                                                        <textarea id="present_address" name="present_address" class="form-control"  placeholder="Enter Present Address" cols="4" required>{{ old('present_address') }}</textarea required>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="parmanent_address">Permanent Address: <span class="text-danger">*</span></label>
                                                        <textarea id="parmanent_address" class="form-control" placeholder="Enter Permanent Address"
                                                            name="parmanent_address" cols="4" required> {{ old('parmanent_address') }} </textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                 <div class="col-md-6 offset-md-3">
                                                    <span id="photoVld" class="text-danger"></span>
                                                    <label for="student-photo">Photo: <span class="text-danger">*</span>
                                                    </label>
                                                    <input  name="uploadfile" data-actualName="image"  type="file" class="" id="student-photo" accept="image/*">

                                                 </div>
                                            </div>
                                                <div class="float-left">
                                                    <button type="button" class="previous btn btn-success"
                                                        onclick="previous(2)">Previous</button>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="next btn btn-success"
                                                    onclick="next(2);" id="next2">Next</button>
                                                </div>
                                        </fieldset>
                                    </div>

                                    <div class="tab" id="tab-3" style="display: none">
                                        <fieldset>
                                            <h2 class="text-center">Academic Information</h2>
                                            <div class="row shadow-lg p-3 mb-5 bg-body rounded">
                                                <div class="col-md-12 text-left">
                                                    <h5>Achademic Information - 1</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exam_name_0">Exam Name:
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select id="exam_name_0" name="exams[0][exam_id]" id="exam_id"  class="form-control exam_id" required>
                                                            <option value="" hidden>Select Your Exam Name</option>
                                                            @foreach ($exam_name as $n)
                                                            <option value="{{$n->id}}" @if( old('exams[0][exam_id]') == $n->id) selected @endif>{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="passing_year_0">Passing Year:</label>
                                                                <input id="passing_year_0" class="form-control year" type="text"name="exams[0][passing_year]" placeholder="Enter Passing Year" value="{{ old('exams[0][passing_year]') }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="division_0">Group:<span class="text-danger">*</span></label>
                                                        <select
                                                            id="division_0" name="exams[0][group]"
                                                            class="form-control" required>
                                                            <option value="" hidden>Select Your Group</option>
                                                            <option value="Science" @if( old('exams[0][group]') == "Science") selected @endif>Science</option>
                                                            <option value="Bussiness Studies" @if( old('exams[0][group]') == "Bussiness Studies") selected @endif>Bussiness Studies</option>
                                                            <option value="Humanities" @if( old('exams[0][group]') == "Humanities") selected @endif>Humanities</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="board_id_0">Board: <span
                                                                class="text-danger">*</span></label>
                                                        <select name="exams[0][board_id]" id="board_id_0"
                                                            class="form-control" required>
                                                            <option value="" hidden>Select Education Board</option>
                                                            @foreach ($board as $n)
                                                            <option value="{{$n->id}}" @if( old('exams[0][board_id]') == $n->id) selected @endif>{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="roll_0">Roll: <span class="text-danger">*</span></label>
                                                        <input id="roll_0" type="number" name="exams[0][roll]" class="form-control"
                                                              value="{{ old('roll') }}" placeholder="Inter Your Roll Number" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="reg_no_0">Registration No: <span class="text-danger">*</span></label>
                                                        <input id="reg_no_0" type="number" name="exams[0][reg_no]" class="form-control"  value="{{ old('reg_no') }}" placeholder="Insert Your Registration Number" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="gpa_0">G.P.A: <span class="text-danger">*</span></label>
                                                        <input id="gpa_0" type="number" max="5.00" name="exams[0][gpa]" step=".01" class="form-control"
                                                            value="{{ old('gpa') }}" placeholder="Enter Your G.P.A" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="reg_card_0">Upload Registration Card: <span
                                                            class="text-danger">*</span></label>
                                                        <div class="">
                                                            <div class="">
                                                                <input name="uploadfile" data-actualName="exams[0][reg_card]" type="file" id="reg_card_0" accept="application/pdf, image/*" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="marksheet_0">Marksheet: <span
                                                            class="text-danger">*</span></label>

                                                        <div class="">
                                                            <div class="">
                                                                <input name="uploadfile" data-actualName="exams[0][marksheet]" type="file" id="marksheet_0" accept="application/pdf, image/*" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Append External exam  --}}
                                            <div id="append_exam">

                                            </div>

                                            {{-- Add More button  --}}
                                            <div id="add_more" class="floating-cart" data-count="1" title="Add new academic info">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                            {{-- <div class="col-md-12  text-right mb-2">
                                                <button id="add_more" type="button" data-count="1"
                                                    class="btn btn-primary">Add More</button>
                                            </div> --}}

                                            {{-- Previous and Next button --}}
                                            {{-- <div class="row"> --}}
                                                <div class="float-left">
                                                    <button type="button" class="previous btn btn-success"
                                                        onclick="previous(3)">Previous</button>
                                                </div>
                                                <div class="float-right">
                                                    <button type="submit" class="button btn btn-success">Submit</button>
                                                </div>
                                            {{-- </div> --}}
                                        </fieldset>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('third_party_scripts')
    {{-- //datpicker --}}
    <script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>

    {{-- file pond  --}}
    <script src="{{ asset('assets/js/pond/filepond-plugin-preview.js') }}"></script>
    <script src="{{ asset('assets/js/pond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('assets/js/pond/filepond-plugin-file-validate-size.js') }}"></script>
    <script src="{{ asset('assets/js/pond/filepond.min.js') }}"></script>
@endpush

@push('page_scripts')
<script>
    $(document).ready(function(){

        addDatePicker("year");

        $('.date').datepicker({
            autoclose: true,
        });

        $('.select').select2();

        file_upload(['#student-photo', '#reg_card_0', '#marksheet_0'], 'uploadfile');

         // This event is for division change
        $('#division').change(function(){
            //$('#district').removeAttr("disabled");
            var division_id = $(this).val();
            if(division_id != '0'){
                $('#district').prop("disabled",false);
            }
            else if(division_id == '0')
            {
                console.log(division_id);
                $('#district').val('');
                $('#district').prop("disabled", true);
            }
            // district_fetch
            var url1 = '{{route('district_fetch.ajax','id')}}'
           var url = url1.replace('id',division_id);
                if(division_id != 0){
                    $('#district').prop('disabled',false);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                    });
                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: url,
                        success:function(respose){

                            var data = '<option value="">Select Your District</option>';
                            $.each(respose,function(key,value){
                                data = data + '<option value="'+value.id+'">'+value.name+'</option>';
                            });
                            $('#district').html(data);
                        }
                    });
                }
        });
    });

    // ajax file upload: selector(element id/class), name(name of the field)
    function file_upload(selectors, name){

        $.each(selectors.reverse(), function( index, selector ) {
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.registerPlugin(FilePondPluginFileValidateType);

            var actualName = $(selector).attr('data-actualName');

            const inputElement = document.querySelector(selector);
            const pond = FilePond.create(inputElement);
            pond.setOptions({
                server:{
                    url: '/file-upload',
                    process: {
                        url: '/uploads',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response_data) => {
                            var f_selector = $('input[name="'+name+'"]');
                            $(f_selector).attr('name', actualName);
                            return response_data;
                        },
                        onerror: (response_data) => {
                            console.log(response_data);
                        },
                        ondata: (formData) => {
                            formData.append('name', name);
                            return formData;
                        },
                    },
                    fetch: null,
                    revert: null,
                }
            });
        });
    }
        //Next Button
        function next(current_div) {
            // $("fieldset").validate();
            var hide = current_div;
            var next = current_div + 1;

            //validation check
            if(current_div == 1){
                if(jQuery.inArray(false,  check_validation(['#departments_id']) ) == -1) {
                    next_process(next, hide);
                }
            }else if(current_div == 2){
                if(jQuery.inArray(false,  check_validation(['#name', '#father_name', '#mother_name', '#email', '#phone', '#gardian_phone', '#gender', ' #dob', '#nationality', '#bg_id', '#division', '#district', '#present_address', '#parmanent_address']) ) == -1) {
                    var a = document.getElementById("gardian_phone").value;
                    var b = document.getElementById("phone").value;
                    if((a.length === 11 && a.length) && (b.length === 11 && b.length))
                    {
                        next_process(next, hide);
                    }
                    else
                    {
                        document.getElementById("next2").disabled = true;
                        $('#guardphn').css('color', 'red');
                        $('#phn').css('color', 'red');
                    }
                }
            }

        }

        function next_process(next, hide){

            //progessbar
            for (i = 1; i <= next; i++) {
                $("#step-" + i).css('opacity', '1');
            }

            // switch tab
            $("#tab-" + hide).css('display', 'none');
            $("#tab-" + next).css('display', 'block');
        }

        //Previous Button
        function previous(current_div) {
            var hide = current_div;
            var previous = current_div - 1;

            // switch tab
            $("#tab-" + hide).css('display', 'none');
            $("#tab-" + previous).css('display', 'block');

            //progessbar
            $("#step-" + hide).css('opacity', '.25');
        }

        $('#add_more').click(function() {

            result = '';
            count = $(this).data('count') + 1;
            $(this).data('count', count);

            result = `<div class="row shadow-lg p-3 mb-5 bg-body rounded" id="aca_mod_${count}">
                        <div class="col-md-6 text-left">
                            <h5>Achademic Information - ${count}</h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-danger" onclick="delete_section(${count})">Remove</button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exam_id_${count - 1}">Exam Name: <span class="text-danger">*</span></label>
                                <select  name="exams[${count - 1}][exam_id]" class="form-control exam_id" id="exam_id_${count - 1}" required>
                                    <option value="" hidden>Select Exam Name</option>
                                    @foreach ($exam_name as $n)
                                        <option value="{{$n->id}}">{{$n->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passing_year_${count - 1}">Passing Year: <span class="text-danger">*</span></label>
                                <input id="passing_year_${count - 1}" class="form-control year" type="text"name="exams[${count - 1}][passing_year]" placeholder="Enter Passing Year" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="division_${count - 1}">Division: <span class="text-danger">*</span></label>
                                <select id="division_${count - 1}" name="exams[${count - 1}][group]"  class="form-control" required>
                                    <option value="" hidden>Select Division</option>
                                    <option value="Science">Science</option>
                                    <option value="Bussiness Studies">Bussiness Studies</option>
                                    <option value="Humanities">Humanities</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="board_id_${count - 1}">Board: <span class="text-danger">*</span></label>
                                <select id="board_id_${count - 1}" name="exams[${count - 1}][board_id]"  class="form-control" required>
                                    <option value="" hidden>Select Education Board</option>
                                    @foreach ($board as $n)
                                        <option value="{{$n->id}}">
                                            {{$n->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="roll_${count - 1}">Roll: <span class="text-danger">*</span></label>
                                <input id="roll_${count - 1}" name="exams[${count - 1}][roll]"  type="text"  placeholder="Enter Roll Number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reg_no_${count - 1}">Registration No: <span class="text-danger">*</span></label>
                                <input id="reg_no_${count - 1}" name="exams[${count - 1}][reg_no]"  type="text"  placeholder="Enter Registration Number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gpa_${count - 1}">G.P.A: <span class="text-danger">*</span></label>
                                <input id="gpa_${count - 1}" name="exams[${count - 1}][gpa]"  type="text"  placeholder="Enter G.P.A" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reg_card_${count - 1}">Upload Registration Card: <span
                                    class="text-danger">*</span></label>
                                <div class="">
                                    <div class="">
                                        <input name="uploadfile" data-actualName="exams[${count - 1}][reg_card]" type="file" id="reg_card_${count-1}" accept="application/pdf, image/*" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marksheet_${count - 1}">Marksheet: <span class="text-danger">*</span>
                                </label>
                                <div class="">
                                    <div class="">
                                        <input name="uploadfile" data-actualName="exams[${count - 1}][marksheet]" type="file" id="marksheet_${count-1}" accept="application/pdf, image/*" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> `;

            $('#append_exam').append(result);
            addDatePicker("year");
            let num = count - 1;
            let reg = '#reg_card_'+num;
            let mark  = '#marksheet_'+num;
            file_upload([reg,mark], 'uploadfile');
        });

        function delete_section(count) {
            $('#aca_mod_' + count).remove();
        };

        function addDatePicker(className){
            $('.'+className).datepicker({
                autoclose: true,
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });
        }

        function check_validation(input_id){
            result = [];
            $.each(input_id.reverse(), function( index, value ) {
                if($(value)[0].checkValidity()){
                    result.push(true);
                }else{
                    $(value).get(0).reportValidity();
                    result.push(false);
                }
            });
            return result;
        }

</script>



<script>
    function phoneNumberChk()
    {
        var gardian_phone = document.getElementById("gardian_phone").value;
        var phone = document.getElementById("phone").value;

        if(gardian_phone.length !== 11 && gardian_phone.length)
        {
            document.getElementById("guardphn").textContent = "Invalid Guardian phone number";
            //document.getElementById("next2").disabled = true;
            //document.getElementById("guardphn").css('background-color', 'Red');
            //return false;
        }
        else if(gardian_phone.length === 11 && gardian_phone.length)
        {
            document.getElementById("guardphn").textContent = "";
            //document.getElementById("next2").disabled = false;

            //return true;
        }
        if(phone.length !== 11 && phone.length)
        {
            document.getElementById("phn").textContent = "Invalid Phone number";
            //document.getElementById("next2").disabled = true;
            //document.getElementById("phn").css('background-color', 'Red');
            //return false;
        }
        else if(phone.length === 11 && phone.length)
        {
            document.getElementById("phn").textContent = "";
            //document.getElementById("next2").disabled = false;
            //return true;
        }
        if((gardian_phone.length === 11 && gardian_phone.length) && (phone.length === 11 && phone.length))
        {
            document.getElementById("next2").disabled = false;
        }
    }

    function phnNumberPost()
    {
        var gardian_phone = document.getElementById("gardian_phone").value;
        var phone = document.getElementById("phone").value;

        if((gardian_phone.length !== 11 && gardian_phone.length) && (phone.length !== 11 && phone.length))
        {
            document.getElementById("next2").disabled = true;
        }
    }
    
</script>
@endpush
