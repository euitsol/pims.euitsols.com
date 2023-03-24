@extends('layouts.app')

@section('title', 'Edit Admitted Student')

@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>

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
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 7px;
            right: 1px;
            width: 20px;
        }
        .select2{
            width: auto;
            display: block;
            /* height: 38px !important; */
        }
        .select2-selection--single {
            height: 38px !important;
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
                            <h4>{{ $page_name }}</h4>
                        </span>
                        {{-- <span class="float-right">
                            @if (Auth::user()->can('user view') || Auth::user()->role->id == 1)<a href="{{ route('employee.new_employee.index') }}" class="btn btn-info">Back</a>@endif
                        </span> --}}
                        <span class="float-right">
                            <a href="{{ route('employee.admitted.accept.list') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include("partial.flush-message")
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <h2 class="text-center">Edit Form</h2>
                                <div align='center'>
                                    <span class="step" id="step-1" style="opacity: 1">1</span>
                                    <span class="step" id="step-2">2</span>
                                    <span class="step" id="step-3">3</span>
                                    <span class="step" id="step-4">4</span>
                                    <span class="step" id="step-5">5</span>
                                </div>

                                <form action="{{ route('employee.admitted.accept.update') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">

                                    {{---------------------------------------------- 
                                                Department Choice Tab-1 
                                    -----------------------------------------------}}
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
                                            <div class="row ml-auto">
                                                <div class="col-md-4 text-right">
                                                    <label for="departments_id">Department Name:<span
                                                        class="text-danger">*</span> </label>
                                                </div>
                                                <div class="col-md-6 text-left">
                                                    <div class="form-group">
                                                        <select id="departments_id" class="select form-control form-validation"
                                                            name="departments_id" required>
                                                            <option value="">Select Department</option>
                                                            @foreach ($department as $n)
                                                            <option value="{{$n->id}}" @if ($n->department_name == $data->department->department_name) selected @endif>{{$n->department_name}}</option>
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

                                    {{---------------------------------------------- 
                                                Personal data Tab-2
                                    -----------------------------------------------}}
                                    <div class="tab" id="tab-2" style="display: none">
                                        <fieldset class="shadow-lg p-3 mb-5 bg-body rounded">
                                            <h2 class="text-center">Personal data</h2>
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Full Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ $data->name }}"  type="text" id="name"
                                                            name="name" placeholder="Full Name" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="father_name">Father's Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ $data->father_name }}"  type="text" id="father_name"
                                                            name="father_name" placeholder="Father's Name"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="mother_name">Mother's Name: <span class="text-danger">*</span></label>
                                                        <input value="{{ $data->mother_name }}"  type="text" id="mother_name"
                                                            name="mother_name" placeholder="Mother's Name"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="email">Email address: </label>
                                                        <input type="email" value="{{ $data->email }}" name="email" id="email"
                                                            class="form-control" placeholder="Email Address">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone">Phone: <span class="text-danger">*</span></label>
                                                        <input value="{{ $data->phone }}"  type="tel" id ="phone"
                                                            name="phone" class="form-control" placeholder="Phone Number" required>
                                                        <small>Phone number must be 11 digits</small>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gardian_phone">Guardian Phone:<span class="text-danger">*</span>    </label>
                                                        <input value="{{ $data->gardian_phone }}" type="tel" id="gardian_phone"
                                                            name="gardian_phone" class="form-control" placeholder="Guardian Phone Number" required>
                                                        <small>Guardian's phone number must be 11 digits</small>
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gender">Gender: <span
                                                                class="text-danger">*</span></label>
                                                        <select class="select form-control"  name="gender" id="gender" required>
                                                            <option value="Male" @if($data->gender=='Male') selected  @endif>Male</option>
                                                            <option  value="Female" @if($data->gender=='Female') selected  @endif> Female</option>
                                                            <option  value="other" @if($data->gender=='other') selected  @endif> Other</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- New column --}}
                                                {{-- ====================================================================================================== --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <fieldset class="p-2 d-flex" style="border:1px solid #ced4da; border-radius:0.25rem">
                                                            <legend class="w-auto" style="font-weight: 700; font-size:1rem;">Merital status: <span
                                                                class="text-danger">*</span></legend>
                                                            <div class="form-check mr-5">
                                                                <input onclick="checkHide()" class="form-check-input" type="radio" name="m_status" value='single' id="single" @if($data->marital_status=='single') checked @endif required>
                                                                <label class="form-check-label" for="single">
                                                                Single
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input onclick="checkShow()"  class="form-check-input" type="radio" name="m_status" value='married' id="married" @if($data->marital_status=='married') checked @endif>
                                                                <label class="form-check-label" for="married" required>
                                                                Merried
                                                                </label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row d-none" id="spouseShow">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="spouse_name">Spouse Name: <span class="text-danger">*</span></label>
                                                                <input value="{{ $data->spouse_name }}"  type="text" id="spouse_name"
                                                                    name="spouse_name" placeholder="Enter Your Spouse Name" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="spouse_number">Spouse Number:<span class="text-danger">*</span>    </label>
                                                                <input value="{{ $data->spouse_number }}" type="number" maxlength="11" minlength="11" id="spouse_number"
                                                                    name="spouse_number" class="form-control" placeholder="Enter Your Spouse Number" onfocusout="phoneNumberChk2()">
        
                                                                <span id="spousenumber">Phone number be must be 11 digits</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- ====================================================================================================== --}}

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="dob">Date of Birth:<span class="text-danger">*</span></label>
                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                            <input type="text" name="dob" value="{{$data->dob}}" class="form-control datetimepicker-input" data-target="#reservationdate" id="dob" required>
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
                                                        <input type="text" name="nationality" value="{{ $data->nationality }}" id="nationality"
                                                             class="form-control date-pick" placeholder="Write Here your Nationality" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bg_id">Blood Group: </label>
                                                        <select class="select form-control"  name="bg_id" id="bg_id">
                                                            <option value="">Select Blood Group</option>
                                                            @foreach ($bg as $n)
                                                            <option value="{{$n->id}}" @if($data->bloodGroup->name==$n->name) selected @endif>{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="division" class="label">Your Division: <span class="text-danger">*</span></label>
                                                        <select id="division" class="select form-control form-validation"  name="division_id" required>
                                                            <option value="">Select Your Division</option>
                                                            @foreach ($division as $n)
                                                            <option value="{{$n->id}}" @if($data->division->name == $n->name) selected @endif>{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="district">Your District: <span class="text-danger">*</span></label>
                                                        <select id="district" class="select form-control"  name="district_id" required>
                                                            <option value="">Select Your District</option>
                                                            @foreach ($district as $n)
                                                            <option value="{{$n->id}}" @if($n->name == $data->district->name) selected @endif>{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="present_address">Present Address: <span class="text-danger">*</span></label>
                                                        <textarea name="present_address" class="form-control"  placeholder="Enter Your Present Address" id="present_address" cols="4">{{ $data->present_address}}</textarea required>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="parmanent_address">Parmanent Address: <span class="text-danger">*</span></label>
                                                        <textarea
                                                            class="form-control" placeholder="Enter Your Parmanent Address" id="parmanent_address"
                                                            name="parmanent_address" required>{{ $data->parmanent_address}} </textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                 <div class="col-md-6 offset-md-3">
                                                    <label for="employee-photo">Photo: <span
                                                        class="text-danger">*</span>
                                                    </label>
                                                    <input  name="uploadfile" data-actualName="image"  type="file" class="" id="employee-photo" accept="image/*">
                                                    <input type="hidden" name="pre_photo" value="{{$data->photo}}">
                                                 </div>
                                            </div>
                                                <div class="float-left">
                                                    <button type="button" class="previous btn btn-success"
                                                        onclick="previous(2)">Previous</button>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="next btn btn-success"
                                                    onclick="next(2)">Next</button>
                                                </div>
                                        </fieldset>
                                    </div>


                                    {{---------------------------------------------------------------- 
                                                Employee Academic Information Tab-3
                                    ------------------------------------------------------------------}}
                                    <div class="tab" id="tab-3" style="display: none">
                                        <fieldset>
                                            <h2 class="text-center">Employee Academic Information</h2>
                                            {{-- //count  --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                            @isset($data->employeeAcademicInfo)
                                                @foreach ($data->employeeAcademicInfo as $ac_data)
                                                    @php
                                                        $i = $i+1;
                                                    @endphp
                                                    <div class="row shadow-lg p-3 mb-5 bg-body rounded academic-info-count" id="aca_mod_{{$loop->index+1}}">
                                                        <input type="hidden" name="exams[{{$loop->index}}][id]" value="{{$ac_data->id}}">
                                                        <div class="col-md-6 text-left">
                                                            <h5>Achademic Information -{{$loop->index+1}}</h5>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <button type="button" class="btn btn-danger" onclick="delete_div({{$loop->index+1}})">Remove</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exam_name_{{$loop->index}}">Exam Name:
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <select  name="exams[{{$loop->index}}][exam_id]" id="exam_id"  class="select form-control form-validation exam_id" id="exam_name_{{$loop->index}}" required>
                                                                    <option value="">Select Your Exam Name</option>
                                                                    @foreach ($exam_name as $n)
                                                                    <option value="{{$n->id}}" @if($ac_data->exam_id == $n->id) selected @endif>{{$n->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="passing_year_{{$loop->index}}">Passing Year:<span
                                                                        class="text-danger">*</span></label>
                                                                        <input class="form-control year" type="text"name="exams[{{$loop->index}}][passing_year]" value="{{$ac_data->passing_year}}" id="passing_year_{{$loop->index}}" placeholder="Year" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="division_{{$loop->index}}">Group:<span class="text-danger">*</span></label>
                                                                <select
                                                                    id="division_{{$loop->index}}" name="exams[{{$loop->index}}][group]"
                                                                    class="form-control" required>
                                                                    <option value="">Select Your Group</option>
                                                                    <option value="Science" @if($ac_data->group == "Science") selected @endif>Science</option>
                                                                    <option value="Bussiness Studies" @if($ac_data->group == "Bussiness Studies") selected @endif>Bussiness Studies</option>
                                                                    <option value="Humanities" @if($ac_data->group == "Humanities") selected @endif>Humanities</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="board_id_{{$loop->index}}">Board: <span
                                                                        class="text-danger">*</span></label>
                                                                <select name="exams[{{$loop->index}}][board_id]" id="board_id_{{$loop->index}}"
                                                                    class="form-control" required>
                                                                    <option value="">Select Education Board</option>
                                                                    @foreach ($board as $n)
                                                                        <option value="{{$n->id}}" @if($ac_data->board_id == $n->id) selected @endif>{{$n->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="roll_{{$loop->index}}">Roll: <span class="text-danger">*</span></label>
                                                                <input type="number" name="exams[{{$loop->index}}][roll]" value="{{$ac_data->roll}}" class="form-control" id="roll_{{$loop->index}}"
                                                                    value="{{ old('roll') }}" placeholder="Inter Your Roll Number" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="reg_no_{{$loop->index}}">Registration No: <span class="text-danger">*</span></label>
                                                                <input type="number" name="exams[{{$loop->index}}][reg_no]" value="{{$ac_data->reg_no}}" class="form-control" placeholder="Insert Your Registration Number" id="reg_no_{{$loop->index}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="gpa_{{$loop->index}}">G.P.A: <span class="text-danger">*</span></label>
                                                                <input type="number" max="5" name="exams[{{$loop->index}}][gpa]" value="{{$ac_data->gpa}}" class="form-control" id="gpa_{{$loop->index}}"
                                                                    placeholder="Enter Your G.P.A">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="reg_card_{{$loop->index}}">Upload Registration Card: <span
                                                                    class="text-danger">*</span></label>
                                                                <div class="">
                                                                    <div class="">
                                                                        <input name="uploadfile" data-actualName="exams[{{$loop->index}}][reg_card]" type="file" id="reg_card_{{$loop->index}}" accept="application/pdf, image/*" value="{{$ac_data->reg_card}}">
                                                                        <input type="hidden" name="exams[{{$loop->index}}][pre_reg_card]" value="{{$ac_data->reg_card}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="marksheet_{{$loop->index}}">Upload Marksheet: <span
                                                                    class="text-danger">*</span></label>

                                                                <div class="">
                                                                    <div class="">
                                                                        <input name="uploadfile" data-actualName="exams[{{$loop->index}}][marksheet]" type="file" id="marksheet_{{$loop->index}}" accept="application/pdf, image/*" value="{{$ac_data->marksheet}}">
                                                                        <input type="hidden" name="exams[{{$loop->index}}][pre_marksheet]" value="{{$ac_data->marksheet}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mx-auto">
                                                            <div class="form-group">
                                                                <label for="certificate_{{$loop->index}}">Upload Certificate: <span
                                                                    class="text-danger">*</span></label>
        
                                                                <div class="">
                                                                    <div class="">
                                                                        <input name="uploadfile" data-actualName="exams[{{$loop->index}}][certificate]" type="file" id="certificate_{{$loop->index}}" accept="application/pdf, image/*" value="{{$ac_data->certificate}}">
                                                                        <input type="hidden" name="exams[{{$loop->index}}][pre_certificate]" value="{{$ac_data->certificate}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            @endisset
                                                {{-- Append External exam  --}}
                                            <div id="append_exam">
                                            </div>

                                            <div id="add_more" class="floating-cart" data-count="{{$i}}" title="Add a new academic info">

                                                <i class="fas fa-plus"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="float-left">
                                                    <button type="button" class="previous btn btn-success"
                                                        onclick="previous(3)">Previous</button>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="next btn btn-success"
                                                    onclick="next(3);" id="next3">Next</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>




                                    {{---------------------------------------------------------------- 
                                                Employee Work Experience Tab-4
                                    ------------------------------------------------------------------}}
                                    <div class="tab Personal-data" id="tab-4" style="display: none">
                                        <fieldset>
                                            <h2 class="text-center">Employee Work Experience</h2>
                                            {{-- //count  --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                        @forelse ($data->employeeExperience as $eex_data)
                                                @php
                                                    $i = $i+1;
                                                @endphp
                                            <div class="row shadow-lg p-3 mb-5 bg-body rounded academic-info-count" id="aca_mod_{{$loop->index+1}}">
                                                <input type="hidden" name="experience[{{$loop->index}}][id]" value="{{$eex_data->id}}">
                                                <div class="col-md-6 text-left">
                                                    <h5>Job Experience - {{$loop->index+1}}</h5>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-danger" onclick="delete_div({{$loop->index+1}})">Remove</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="job_designation_{{$loop->index}}">Designation: </label>
                                                                <input id="job_designation_{{$loop->index}}" class="form-control" type="text" name="experience[{{$loop->index}}][job_designation]" placeholder="Enter Your Designation" value="{{$eex_data->designation ?? ''}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="company_{{$loop->index}}">Company Name:</label>
                                                                <input id="company_{{$loop->index}}" class="form-control" type="text" name="experience[{{$loop->index}}][company]" placeholder="Enter Your Company N" value="{{$eex_data->company_name ?? ''}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <label class="col-sm-3" for="start_month_{{$loop->index}}">Job Duration </label>
                                                            <div class="input-group input-daterange" id="year">
                                                                <input type="text" class="form-control dueyear" id="start_month_{{$loop->index}}" name="experience[{{$loop->index}}][start_month]" value="{{$eex_data->job_start ?? ''}}" >
                                                            <div class="input-group-append"><div class="input-group-text">to</div></div>
                                                                <input type="text" class="form-control dueyear" id="end_month_{{$loop->index}}" name="experience[{{$loop->index}}][end_month]" value="{{$eex_data->job_end ?? ''}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mx-auto">
                                                    <div class="form-group">
                                                        <label for="ec_{{$loop->index}}">Upload Experience Certificate: </label>
    
                                                        <div class="">
                                                            <div class="">
                                                                <input name="uploadfile" data-actualName="experience[{{$loop->index}}][ec]" type="file" id="ec_{{$loop->index}}" accept="application/pdf, image/*" value="{{$eex_data->ex_certificate ?? ''}}">
                                                                <input type="hidden" name="experience[{{$loop->index}}][pre_ec]" value="{{$eex_data->ex_certificate}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                             @php
                                                $i = $i+1;
                                            @endphp
                                            <div class="row shadow-lg p-3 mb-5 bg-body rounded academic-info-count" id="aca_mod_1">
                                                <input type="hidden" name="experience[0][id]" value="">
                                                <div class="col-md-6 text-left">
                                                    <h5>Job Experience - 1</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="job_designation_0">Designation: </label>
                                                                <input id="job_designation_0" class="form-control" type="text" name="experience[0][job_designation]" placeholder="Enter Your Designation" value="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="company_0">Company Name:</label>
                                                                <input id="company_0" class="form-control" type="text" name="experience[0][company]" placeholder="Enter Your Company N" value="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <label class="col-sm-3" for="start_month_0">Job Duration </label>
                                                            <div class="input-group input-daterange" id="year">
                                                                <input type="text" class="form-control dueyear" id="start_month_0" name="experience[0][start_month]" value="" >
                                                            <div class="input-group-append"><div class="input-group-text">to</div></div>
                                                                <input type="text" class="form-control dueyear" id="end_month_0" name="experience[0][end_month]" value="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mx-auto">
                                                    <div class="form-group">
                                                        <label for="ec_0">Upload Experience Certificate: </label>
    
                                                        <div class="">
                                                            <div class="">
                                                                <input name="uploadfile" data-actualName="experience[0][ec]" type="file" id="ec_0" accept="application/pdf, image/*" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                                {{-- Append External exam  --}}
                                            <div id="append_experience">

                                            </div>

                                            {{-- Add More button  --}}
                                            <div id="add_more2" class="floating-cart" data-count="{{$i}}" title="Add new academic info">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                            {{-- <div class="col-md-12  text-right mb-2">
                                                <button id="add_more" type="button" data-count="1"
                                                    class="btn btn-primary">Add More</button>
                                            </div> --}}
                                                <div class="col-12">
                                                    <div class="float-left">
                                                        <button type="button" class="previous btn btn-success"
                                                            onclick="previous(4)">Previous</button>
                                                    </div>
                                                    <div class="float-right">
                                                        <button type="button" class="next btn btn-success"
                                                        onclick="next(4);" id="next4">Next</button>
                                                    </div>
                                                </div>
                                        </fieldset>
                                    </div>



                                    {{---------------------------------------------------------------- 
                                                Employee Document Tab-5
                                    ------------------------------------------------------------------}}
                                    <div class="tab" id="tab-5" style="display: none">
                                    <fieldset>
                                        <h2 class="text-center">Employee Document</h2>
                                    @isset($data->employeeDocument)
                                        @foreach ($data->employeeDocument as $ed_data)
                                        
                                        <div class="row shadow-lg p-3 mb-5 bg-body rounded">
                                            <input type="hidden" name="document[0][id]" value="{{$ed_data->id}}">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="designation_id_0">Designation: <span
                                                            class="text-danger">*</span></label>
                                                    <select name="document[0][designation_id]" id="designation_id_0"
                                                        class="form-control" required>
                                                        <option value="" selected>Select Your Designation</option>
                                                        @foreach ($designation as $n)
                                                        <option value="{{$n->id}}" @if($ed_data->designation_id == $n->id) selected @endif>{{$n->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nidordob_card_0">NID card or DOB Card: <span
                                                        class="text-danger">*</span></label>
                                                    <div class="">
                                                        <div class="">
                                                            <input name="uploadfile" data-actualName="document[0][nidordob_card]" type="file" id="nidordob_card_0" accept="application/pdf, image/*" value="{{$ed_data->nid_or_dob}}">>
                                                            <input type="hidden" name="document[0][pre_nidordob_card]" value="{{$ed_data->nid_or_dob}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cv_0">CV: <span
                                                        class="text-danger">*</span></label>

                                                    <div class="">
                                                        <div class="">
                                                            <input name="uploadfile" data-actualName="document[0][cv]" type="file" id="cv_0" accept="application/pdf, image/*" {{$ed_data->cv}}>
                                                            <input type="hidden" name="document[0][pre_cv]" value="{{$ed_data->cv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mx-auto">
                                                <div class="form-group">
                                                    <label for="cc_0">Character Certificate: <span
                                                        class="text-danger">*</span></label>

                                                    <div class="">
                                                        <div class="">
                                                            <input name="uploadfile" data-actualName="document[0][cc]" type="file" id="cc_0" accept="application/pdf, image/*" value="{{$ed_data->character_certificate}}">
                                                            <input type="hidden" name="document[0][pre_cc]" value="{{$ed_data->character_certificate}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        @endforeach
                                    @endisset

                                        {{-- Previous and Next button --}}
                                        {{-- <div class="row"> --}}
                                            <div class="float-left">
                                                <button type="button" class="previous btn btn-success"
                                                    onclick="previous(5)">Previous</button>
                                            </div>
                                            <div class="float-right">
                                                <button type="submit" class="button btn btn-success">Update</button>
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

    {{-- <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script> --}}
@endpush

@push('page_scripts')
<script>
    function delete_div(count) {
        if(count!=1){
            $('#aca_mod_' + count).remove();
        }

    };

    $(document).ready(function(){

        addDatePicker("year");
        addDurationDatePicker("dueyear")
        $('.date').datepicker();
        $('.select').select2();

        file_upload(['#employee-photo'], 'uploadfile');
        $.each({!! str_replace("'", "\'", json_encode($data->employeeAcademicInfo)) !!},function(key,value){
            file_upload(['#marksheet_'+key, '#reg_card_'+key, '#certificate_'+key], 'uploadfile');
        });
        $.each({!! str_replace("'", "\'", json_encode($data->employeeExperience)) !!},function(key,value){
            file_upload(['#ec_'+key], 'uploadfile');
        });
        $.each({!! str_replace("'", "\'", json_encode($data->employeeDocument)) !!},function(key,value){
            file_upload(['#nidordob_card_'+key, '#cv_'+key, '#cc_'+key], 'uploadfile');
        });
         // This event is for division change
        $('#division').change(function(){
            $('#district').removeAttr("disabled");
            var division_id = $(this).val();

            let url = ("{{ route('district_fetch.ajax', 'id') }}");
            let _url = url.replace('id', division_id);
                if(division!=""){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                    });
                    $.ajax({
                        type: "GET",
                        dataType: 'json',

                        url: _url,
                        success:function(respose){
                            console.log(respose);
                            var data = '<option value="" hidden>Select Your District</option>';
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
            /*==================
                    Tab-1
            ===================*/
            if(current_div == 1){
                if(jQuery.inArray(false,  check_validation(['#departments_id']) ) == -1) {
                    next_process(next, hide);
                }
            }
            
            /*==================
                    Tab-2
            ===================*/
            else if(current_div == 2){
                if(jQuery.inArray(false,  check_validation(['#name', '#father_name', '#mother_name', '#email', '#phone', '#gender','#single', '#married', ' #dob', '#nationality', '#bg_id', '#division', '#district', '#present_address', '#parmanent_address']) ) == -1) {
                    
                    
                    next_process(next, hide);
                    // var a = document.getElementById("spouse_number").value;
                    // var b = document.getElementById("phone").value;
                    // var option = null;
                    // var option2 = null;
                    // if(document.getElementById('married').checked)
                    // {
                    //     option = document.getElementById('married').value;
                    //     console.log("Married");
                    // }
                    // else if(document.getElementById('single').checked)
                    // {
                    //     option2 = document.getElementById('single').value;
                    //     console.log("Single");
                    // }

                    // if(option !== null){
                    //     if((a.length === 11 && a.length) && (b.length === 11 && b.length))
                    //     {
                    //         document.getElementById("next2").disabled = false;
                    //         next_process(next, hide);
                    //     }
                    //     else
                    //     {
                    //         document.getElementById("next2").disabled = true;
                    //         console.log("111");
                    //         $('#spousenumber').css('color', 'red');
                    //         $('#phn').css('color', 'red');
                    //     }
                    // }
                    // else if(option2 !== null)
                    // {
                    //     if((b.length === 11 && b.length) && (a.length !== 11 || a.length == ''))
                    //     {
                    //         document.getElementById("next2").disabled = false;
                    //         next_process(next, hide);
                    //     }
                    //     else
                    //     {
                    //         document.getElementById("next2").disabled = true;
                    //         console.log("222");
                    //         $('#spousenumber').removeAttr('style');
                    //         $('#phn').css('color', 'red');
                    //     }
                    // }
                }
            }


            /*==================
                    Tab-3
            ===================*/
            else if(current_div == 3){
                    next_process(next, hide);
            }

            /*==================
                    Tab-4
            ===================*/
            else if(current_div == 4){
                next_process(next, hide);
            }

        }
        /*==================
            next_process
        ===================*/
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

        /*==========================================
            Employee Academic Information Duplicate
        =============================================*/
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
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label for="certificate_${count - 1}">Certificate: <span class="text-danger">*</span>
                            </label>
                            <div class="">
                                <div class="">
                                    <input name="uploadfile" data-actualName="exams[${count - 1}][certificate]" type="file" id="certificate_${count-1}" accept="application/pdf, image/*" required>
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
        let cert  = '#certificate_'+num;
        let niddob = '#nidordob_card_'+num;
        let cv = '#cv_'+num;
        let cc = '#cc_'+num;
        file_upload([reg,mark, cert, niddob, cv, cc], 'uploadfile');
        });

        /*==========================================
        Employee Work Experience Duplicate
        =============================================*/
        $('#add_more2').click(function(){
        result = '';
        count = $(this).data('count') + 1;
        $(this).data('count', count);

        result = `<div class="row shadow-lg p-3 mb-5 bg-body rounded" id="aca_mod_${count}">
                    <div class="col-md-6 text-left">
                        <h5>Job Experience - ${count}</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-danger" onclick="delete_section(${count})">Remove</button>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_designation_${count - 1}">Designation:</label>
                                    <input id="job_designation_${count - 1}" class="form-control" type="text"name="experience[${count - 1}][job_designation]" placeholder="Enter Your Designation" value="{{ old('experience[${count - 1}][job_designation]') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_${count - 1}">Company Name:</label>
                                    <input id="company_${count - 1}" class="form-control" type="text"name="experience[${count - 1}][company]" placeholder="Enter Your Company N" value="{{ old('experience[${count - 1}][company]') }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label class="col-sm-3" for="start_month_${count - 1}">Duration<span class="text-danger">*</span></label>
                                <div class="input-group input-daterange" id="year">
                                    <input type="text" class="form-control dueyear" id="start_month_${count - 1}" name="experience[${count - 1}][start_month] year" value={{ old('start_month') }}>
                                <div class="input-group-append"><div class="input-group-text">to</div></div>
                                    <input type="text" class="form-control dueyear" id="end_month_${count - 1}" name="experience[${count - 1}][end_month]" value={{ old('end_month') }}>
                                </div>
                                @if ($errors->has('start_month_${count - 1}'))
                                    <span class="text-danger">{{ $errors->first('start_month_${count - 1}') }}</span>
                                @endif
                                @if ($errors->has('end_month_${count - 1}'))
                                    <span class="text-danger">{{ $errors->first('end_month_${count - 1}') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label for="ec_${count - 1}">Experience Certificate: </label>

                            <div class="">
                                <div class="">
                                    <input name="uploadfile" data-actualName="experience[${count - 1}][ec]" type="file" id="ec_${count - 1}" accept="application/pdf, image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            
        $('#append_experience').append(result);
        addDurationDatePicker('dueyear');
        let num = count - 1;
        let ec = '#ec_'+num;
        file_upload([ec], 'uploadfile');
        });


        function delete_section(count) {
        $('#aca_mod_' + count).remove();
        };


 /*===============================
            Passing Year Date Picker
        ==================================*/
        function addDatePicker(className){
            $('.'+className).datepicker({
                autoclose: true,
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });
        }

        /*===============================
            Job Duration Date Picker
        =================================*/
        function addDurationDatePicker(className){
            $('.'+className).datepicker({
                autoclose: true,
                format: "MM yyyy",
                startView: "months",
                minViewMode: "months",
                changeMonth: true,
                changeYear: true,
            });
        }

        /*====================
            Validation Check
        =======================*/
        function check_validation(input_id){
            result = [];
            $.each(input_id.reverse(), function( index, value ) {
                if($(value)[0].checkValidity()){
                    result.push(true);
                }else{
                    $(value)[0].reportValidity();
                    result.push(false);
                }
            });
            return result;
        }

</script>
<script>
    /*================================
            Number Validation
    ==================================*/
    function phoneNumberChk()
    {
        var phone = document.getElementById("phone").value;
        if(phone.length !== 11 && phone.length)
        {
            document.getElementById("phn").textContent = "Invalid Phone number";
            document.getElementById("next2").disabled = true;
            //document.getElementById("phn").css('background-color', 'Red');
            //return false;
        }
        else if(phone.length === 11 && phone.length)
        {
            document.getElementById("phn").textContent = "";
            document.getElementById("next2").disabled = false;
            //return true;
        }
        // if((phone.length === 11 && phone.length))
        // {
        //     document.getElementById("next2").disabled = false;
        // }
    }


    function phoneNumberChk2()
    {
        var option = document.getElementById('married').value;
        var option2 = document.getElementById('single').value;
        var spouse_number = document.getElementById("spouse_number").value;
        var employee_number = document.getElementById("phone").value;

        if(option){
            if((spouse_number.length !== 11 && spouse_number.length) || (employee_number.length !== 11 && employee_number.length))
            {
                document.getElementById("spousenumber").textContent = "Invalid Spouse phone number";
                document.getElementById("next2").disabled = true;
                //document.getElementById("spousenumber").css('background-color', 'Red');
                //return false;
            }
            else if((spouse_number.length === 11 && spouse_number.length) && (employee_number.length === 11 && employee_number.length))
            {
                document.getElementById("spousenumber").textContent = "";
                document.getElementById("next2").disabled = false;
                //return true;
            }
            // if((spouse_number.length === 11 && spouse_number.length))
            // {
            //     document.getElementById("next2").disabled = false;
            // }
        }
        if(option2){
            document.getElementById("next2").disabled = false;
            document.getElementById("spousenumber").textContent = "";

            if(employee_number.length !== 11)
            {
                document.getElementById("phone").textContent = "Invalid phone number";
                document.getElementById("next2").disabled = true;
                //document.getElementById("spousenumber").css('background-color', 'Red');
                //return false;
            }
            else if(employee_number.length === 11 && employee_number.length)
            {
                document.getElementById("phone").textContent = "";
                document.getElementById("next2").disabled = false;
                console.log("Yeesss");
                //return true;
            }

        }
    }
    
</script>

<script>
    /*=============================================
            merrital status check show and hide
    ===============================================*/
    function checkShow(){
        var option = document.getElementById('married').value;
        console.log(option);
        var element = document.getElementById("spouseShow");
        console.log(element);
        if(option){
            element.classList.remove("d-none");
        }
    }
    function checkHide(){
        var option = document.getElementById('single').value;
        console.log(option);
        var element = document.getElementById("spouseShow");
        console.log(element);
        if(option){
            element.classList.add("d-none"); 
        }
    }
</script>
@endpush
