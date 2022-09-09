@extends('layouts.app')

@section('title', 'Admit Student')

@push('third_party_stylesheets')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
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
                            {{-- @if (Auth::user()->can('user view') || Auth::user()->role->id == 1)<a href="{{ route('users.index') }}" class="btn btn-info">Back</a>@endif --}}
                        </span>
                    </div>
                    <div class="card-body">
                        @include("partial.flush-message")
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <h2 class="text-center">Admission Form</h2>
                                <div align='center'>
                                    <span class="step" id="step-1">1</span>
                                    <span class="step" id="step-2">2</span>
                                    <span class="step" id="step-3">3</span>
                                </div>

                                <form id="basic-form" action="{{ route('student-admit.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="tab" id="tab-1">
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
                                            <div class="row index1">
                                                <div class="col-md-12 ml-auto">
                                                    <div class="form-group">
                                                        <label for="departments_id">Department Name:<span
                                                            class="text-danger">*</span> </label>
                                                        <select id="form" class="select form-control form-validation"
                                                            name="departments_id">
                                                            <option value="">Select Department</option>
                                                            @foreach ($department as $n)
                                                            <option value="{{$n->id}}">{{$n->department_name}}"</option>
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
                                    <div class="tab" id="tab-2">
                                        <fieldset>
                                            <h2 class="text-center">Personal data</h2>
                                            <div class="row index">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Full Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('name') }}" required type="text"
                                                            name="name" placeholder="Full Name" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="father_name">Father's Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('father_name') }}" required type="text"
                                                            name="father_name" placeholder="Father's Name"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="mother_name">Mother's Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('mother_name') }}" required type="text"
                                                            name="mother_name" placeholder="Mother's Name"
                                                            class="form-control">
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="present_address">Present Address: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('present_address') }}" required
                                                            class="form-control" placeholder="Present Address"
                                                            name="present_address" type="text" required>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="parmanent_address">Parmanent Address: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('parmanent_address') }}" required
                                                            class="form-control" placeholder="Parmanent Address"
                                                            name="parmanent_address" type="text" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="email">Email address: </label>
                                                        <input type="email" value="{{ old('email') }}" name="email"
                                                            class="form-control" placeholder="Email Address">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone">Phone: <span class="text-danger">*</span></label>
                                                        <input value="{{ old('phone') }}" required type="text"
                                                            name="phone" class="form-control" placeholder="Phone Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gardian_phone">Guardian Phone:<span class="text-danger">*</span>    </label>
                                                        <input value="{{ old('gardian_phone') }}" type="text"
                                                            name="gardian_phone" class="form-control" placeholder="Guardian Phone Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gender">Gender: <span
                                                                class="text-danger">*</span></label>
                                                        <select class="select form-control"  name="gender"
                                                            required>
                                                            <option value="Male">Male</option>
                                                            <option  value="Female"> Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Date of Birth:<span class="text-danger">*</span></label>
                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                            <input type="text" name="dob" class="form-control datetimepicker-input" data-target="#reservationdate">
                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <div class="input-group date" id="reservationdate"  data-target-input="nearest">
                                                            <input type="text" name="dob" class="form-control datetimepicker-input" data-target="#reservationdate">
                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                <div class="input-group-text">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label for="dob">Date of Birth: <span class="text-danger">*</span></label>
                                                        <input  name="dob" value="dd-mm-yy" required
                                                            type="text" class="date form-control date-pick">
                                                    </div> --}}
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nationality">Nationality: <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="nationality" value="{{ old('nationality') }}"
                                                             class="form-control date-pick" placeholder="Write Here your Nationality" required >
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bg_id">Blood Group: </label>
                                                        <select class="select form-control"  name="bg_id">
                                                            <option value="">Select Blood Group</option>
                                                            {{-- @foreach ($bg as $n)
                                                            <option value="{{$n->id}}">{{$n->department_name}}"</option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Quota</label>
                                                        <input name="quota" value="{{ old('quota') }}" type="text"
                                                            class="form-control date-pick" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="photo">Photo: <span
                                                        class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input name="photo" type="file" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label for="photo">Photo: <span
                                                                class="text-danger">*</span></label>
                                                        <input value="{{ old('photo') }}" required
                                                            accept=".pdf,.png,.jpg" type="file" name="photo"
                                                            class="form-input-styled">
                                                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max
                                                            file size
                                                            2Mb</span>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 text-left">
                                                    <button type="button" class="previous btn btn-success"
                                                        onclick="previous(2)">Previous</button>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="next btn btn-success"
                                                        onclick="next(2)">Next</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="tab" id="tab-3">
                                        <fieldset>
                                            <h2 class="text-center">Academic Information</h2>
                                            <div class="row shadow-lg p-3 mb-5 bg-body rounded">
                                                <div class="col-md-12 text-left">
                                                    <h5>Achademic Information - 1</h5>
                                                </div>
                                                {{-- validation --}}
                                                {{-- 'exams.*.exam_name' => 'required|exists:exams,id', --}}
                                                {{-- controller --}}
                                                {{-- foreach ($request->exams as $data) {
                                                $data['exam_name']
                                                $data['exam_name']
                                                $data['exam_name']
                                                $data['exam_name']
                                                $data['exam_name']
                                                $data['exam_name']
                                                }
                                                --}}

                                                {{-- save format --}}
                                                {{-- exam-info/$user_id --}}

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exam_name">Exam Name:
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select  name="exams[0][exam_id]" id="exam_id" required class="form-control">
                                                            <option value="">Select Your Exam Name</option>
                                                            @foreach ($exam_name as $n)
                                                            <option value="{{$n->id}}">{{$n->name}}"</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="passing_year">Passing Year:<span
                                                                class="text-danger">*</span></label>
                                                                <input class="form-control year" type="text"name="exams[0][passing_year]" placeholder="Year">
                                                        {{-- <select id="passing_year" name="exams[0][passing_year]" class="form-control"  required>
                                                            <option value="">Select Your Passing Year</option>

                                                        </select> --}}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="division">Division:<span class="text-danger">*</span></label>
                                                        <select
                                                            id="division" name="exams[0][division]"
                                                            class="form-control" required>
                                                            <option value="">Select Your Division</option>
                                                            <option value="Science">Science</option>
                                                            <option value="Bussiness Studies">Bussiness Studies</option>
                                                            <option value="Humanities">Humanities</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="board_id">Board: <span
                                                                class="text-danger">*</span></label>
                                                        <select name="exams[0][board_id]"
                                                            class="form-control" required>
                                                            <option value="">Select Education Board</option>
                                                            @foreach ($board as $n)
                                                            <option value="{{$n->id}}">{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="roll">Roll: <span class="text-danger">*</span></label>
                                                        <input type="text" name="exams[0][roll]" class="form-control"
                                                              value="{{ old('roll') }}" placeholder="Inter Your Roll Number" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="reg_no">Registration No: <span class="text-danger">*</span></label>
                                                        <input type="text" name="exams[0][reg_no]" class="form-control"  value="{{ old('reg_no') }}" placeholder="Insert Your Registration Number" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gpa">G.P.A: <span class="text-danger">*</span></label>
                                                        <input type="text"  name="exams[0][gpa]" class="form-control"
                                                            value="{{ old('gpa') }}" placeholder="Enter Your G.P.A" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="reg_card">Upload Registration Card: <span
                                                            class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input name="exams[0][reg_card]" type="file" class="custom-file-input" >
                                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Upload</span>
                                                            </div>
                                                        </div>
                                                        {{-- <label for="reg_card" class="d-block">Upload Registration Card: <span
                                                                class="text-danger">*</span></label>
                                                        <input type="file"   class="form-input-styled" accept=".pdf,.png,.jpg" value="{{ old('reg_card') }}" required>
                                                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max
                                                            file size
                                                            2Mb</span> --}}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="marksheet">Marksheet: <span
                                                            class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input name="exams[0][marksheet]" type="file" class="custom-file-input" accept=".pdf,.png,.jpg">
                                                                <label class="custom-file-label" for="marksheet">Choose file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Upload</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        {{-- <label for="marksheet" class="d-block">Marksheet: <span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" name="exams[0][marksheet]" class="form-input-styled" accept=".pdf,.png,.jpg" value="{{ old('marksheet') }}" required>
                                                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max
                                                            file size
                                                            2Mb</span> --}}

                                                </div>
                                            </div>

                                            {{-- Append External exam  --}}
                                            <div id="append_exam">

                                            </div>

                                            {{-- Add More button  --}}
                                            <div id="add_more" class="floating-cart" data-count="1">
                                                <i class="fas fa-plus"></i>
                                                <div class="cart-count">
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12  text-right mb-2">
                                                <button id="add_more" type="button" data-count="1"
                                                    class="btn btn-primary">Add More</button>
                                            </div> --}}

                                            {{-- Previous and Next button --}}
                                            <div class="row">
                                                <div class="col-md-6 text-left">
                                                    <button type="button" class="previous btn btn-success"
                                                        onclick="previous(3)">Previous</button>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="submit" class="button btn btn-success">Submit</button>
                                                </div>
                                            </div>
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
    {{-- <script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script> --}}
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> --}}
@endpush

@push('page_scripts')
    <script>

       $(document).ready(function(){
        $('.tab').css('display', 'none');
        $('#tab-1').css('display', 'block');
        $('#step-1').css('opacity', '1');
        addDatePicker("year");
        $('.date').datepicker();

       });
    //    $('#form').validate();

        //Next Button
        function next(current_div) {
            // $("fieldset").validate();
            var hide = current_div;
            var next = current_div + 1;

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
            // for(hide;hide>0;hide--){
            // }
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exam_id">Exam Name: <span class="text-danger">*</span></label>
                                <select required name="exams[${count - 1}][exam_id]" class="form-control">
                                    <option value="">Select Your Exam Name</option>
                                    @foreach ($exam_name as $n)
                                        <option
                                        value="{{$n->id}}">{{$n->name}}"</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="passing_year">Passing Year: <span class="text-danger">*</span></label>
                                <input class="form-control year" type="text"name="exams[${count - 1}][passing_year]" placeholder="Year">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="division">Division: <span class="text-danger">*</span></label>
                                <select name="exams[${count - 1}][division]" required class="form-control">
                                    <option value="">Select Your Division</option>
                                    <option value="Science">Science</option>
                                    <option value="Bussiness Studies">Bussiness Studies</option>
                                    <option value="Humanities">Humanities</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="board_id">Board: <span class="text-danger">*</span></label>
                                <select name="exams[${count - 1}][board_id]" required class="form-control">
                                    <option value="">Select Education Board</option>
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
                                <label>Roll: <span class="text-danger">*</span></label>
                                <input name="exams[${count - 1}][roll]"  type="text" required placeholder="Inter Your Roll Number" class="form-control" value="{{ old('roll') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Registration No: <span class="text-danger">*</span></label>
                                <input name="exams[${count - 1}][reg_no]"  type="text" required placeholder="Insert Your Registration Number" class="form-control" value="{{ old('reg_no') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>G.P.A: <span class="text-danger">*</span></label>
                                <input name="exams[${count - 1}][gpa]"  type="text" required placeholder="Enter Your G.P.A" class="form-control" value="{{ old('gpa') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reg_card">Upload Registration Card: <span
                                    class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="exams[${count - 1}][reg_card]" type="file" class="custom-file-input" >
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="marksheet">Marksheet: <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="exams[${count - 1}][marksheet]" type="file" class="custom-file-input" accept=".pdf,.png,.jpg">
                                        <label class="custom-file-label" for="marksheet">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> `;

            $('#append_exam').append(result);
            addDatePicker("year");
        });

        function delete_section(count) {
            $('#aca_mod_' + count).remove();
        };

        // $('.year').each(function()
        // {
        //     $(this).datepicker({
        //     autoclose: true,
        //     format: " yyyy",
        //     viewMode: "years",
        //     minViewMode: "years"
        //  });
        // });

        function addDatePicker(className){
            $('.'+className).datepicker({
                autoclose: true,
                format: " yyyy",
                viewMode: "years",
                minViewMode: "years"
            });
        }

    </script>

@endpush
