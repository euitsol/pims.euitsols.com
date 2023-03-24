@extends('layouts.app')

@section('title', 'Teacher Management')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
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
                            <h4>Add Teacher</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('teacher.index') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @include('partial.flush-message')
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <form action="{{ route('teacher.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">


                                        <div class="col-sm-8">
                                            <div>
                                                <label class="" for="name">Teacher Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name') }}" placeholder="Enter Teacher's Name" required>
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <label class="mt-3" for="department">Department<span
                                                        class="text-danger">*</span></label>

                                                <select class="form-control" name="departments" id="department">
                                                    <option value="">Select Department</option>
                                                    @foreach ($depts as $department)
                                                        <option value="{{ $department->id }}" @if( old('departments') == $department->id ) selected @endif>{{ $department->department_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('department'))
                                                    <span class="text-danger">{{ $errors->first('department') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="col-sm-4">
                                            <label class="" for="image">Photo<span
                                                    class="text-danger"></span></label>
                                            <input name="uploadfile" data-actualName="image" type="file" id="image"
                                                accept="image/*">
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-6" for="divisions">Division<span
                                                class="text-danger">*</span></label>

                                        <label class="col-sm-6" for="districts">District<span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-6">
                                            <select class="form-control" name="divisions" id="divisions">
                                                <option value="">Select Division</option>
                                                @foreach ($division as $divisions)
                                                    <option value="{{ $divisions->id }}" @if( old('divisions') == $divisions->id ) selected @endif>{{ $divisions->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('divisions'))
                                                <span class="text-danger">{{ $errors->first('divisions') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-sm-6">
                                            <select class="form-control" name="districts" id="districts">
                                                <option value="">Select Districts</option>
                                                @foreach ($district as $districts)
                                                    <option value="{{ $districts->id }}" @if( old('districts') == $districts->id ) selected @endif>{{ $districts->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('districts'))
                                                <span class="text-danger">{{ $errors->first('districts') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-6" for="role">Blood Group<span
                                                class="text-danger">*</span></label>

                                        <label class="col-sm-6">Date of Birth:<span class="text-danger">*</span></label>

                                        <div class="col-sm-6">
                                            <select class="form-control" name="bloodgroups" id="bloodgroup">
                                                <option value="">Select Blood Group</option>
                                                @foreach ($blood_group as $bloodgroups)
                                                    <option value="{{ $bloodgroups->id }}" @if( old('bloodgroups') == $bloodgroups->id ) selected @endif>{{ $bloodgroups->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('bloodgroups'))
                                                <span class="text-danger">{{ $errors->first('bloodgroups') }}</span>
                                            @endif
                                        </div>

                                        <div class="input-group date col-sm-6" id="reservationdate"
                                            data-target-input="nearest">
                                            <input type="text" name="date_of_birth"
                                                class="form-control datetimepicker-input" data-target="#reservationdate"
                                                placeholder="Enter Your Date Of Birth" value="{{ old('date_of_birth') }}">

                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-6" for="phone">Phone<span
                                                class="text-danger">*</span></label>

                                        <label class="col-sm-6" for="name">Email<span
                                                class="text-danger">*</span></label>


                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" id="phone" name="phone"
                                                value="{{ old('phone') }}" placeholder="Enter Teacher's Phone" onfocusout="phoneNumberChk()" required>
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                            <span id="phn" class="text-danger"></span>
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email') }}" placeholder="Enter Email Address" required>
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-6" for="role">Gender<span
                                                class="text-danger"></span></label>

                                        <label class="col-sm-6" for="nid">NID<span
                                                class="text-danger"></span></label>

                                        <div class="col-sm-6">
                                            <select class="form-control" name="gender" id="gender">
                                                <option value="" hidden>Select Gender</option>
                                                <option value="Male" @if( old('gender') == "Male" ) selected @endif>Male</option>
                                                <option value="Female" @if( old('gender') == "Female" ) selected @endif>Female</option>
                                                <option value="Other" @if( old('gender') == "Other" ) selected @endif>Other</option>
                                            </select>
                                            @if ($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" id="nid" name="nid"
                                                value="{{ old('nid') }}" placeholder="Enter Teacher's NID">
                                            @if ($errors->has('nid'))
                                                <span class="text-danger">{{ $errors->first('nid') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12" for="name">Present Address<span
                                                class="text-danger"></span></label>
                                        <div class="col-sm-12">
                                            <textarea name="present_address" class="form-control"
                                                placeholder="Enter Your Present Address" cols="4">{{ old('present_address') }}</textarea>
                                            @if ($errors->has('present_address'))
                                                <span class="text-danger">{{ $errors->first('present_address') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12" for="name">Permanant Address<span
                                                class="text-danger"></span></label>
                                        <div class="col-sm-12">
                                            <textarea name="permanant_address" class="form-control"
                                                placeholder="Enter Your Permanant Address" cols="4">{{ old('permanant_address') }}</textarea>
                                            @if ($errors->has('permanant_address'))
                                                <span class="text-danger">{{ $errors->first('permanant_address') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-12" for="guard_name"></label>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100" id="addTeacher" onclick="phnNumberPost()">Add Teacher</button>
                                        </div>
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
    <script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>

    {{-- file pond  --}}
    <script src="{{ asset('assets/js/pond/filepond-plugin-preview.js') }}"></script>
    <script src="{{ asset('assets/js/pond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('assets/js/pond/filepond-plugin-file-validate-size.js') }}"></script>
    <script src="{{ asset('assets/js/pond/filepond.min.js') }}"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $("#divisions, #gender, #department, #districts, #bloodgroup").select2();

            file_upload(['#image'], 'uploadfile');

            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true
            });

            $('#divisions').change(function() {
                $('#districts').removeAttr("disabled");
                var division_id = $(this).val();

                if (division_id != "") {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: `{{ url('teacher/division_ajax') }}/` + division_id,
                        success: function(respose) {
                            var data = '<option value="">Select Your District</option>';
                            $.each(respose, function(key, value) {
                                data = data + '<option value="' + value.id + '">' +
                                    value.name +
                                    '</option>';
                            });
                            $('#districts').html(data);
                        }
                    });
                }
            });
        });

        function file_upload(selectors, name) {
            $.each(selectors.reverse(), function(index, selector) {
                FilePond.registerPlugin(FilePondPluginImagePreview);
                FilePond.registerPlugin(FilePondPluginFileValidateSize);
                FilePond.registerPlugin(FilePondPluginFileValidateType);
                var actualName = $(selector).attr('data-actualName');
                const inputElement = document.querySelector(selector);
                const pond = FilePond.create(inputElement);
                pond.setOptions({
                    server: {
                        url: '/file-upload',
                        process: {
                            url: '/uploads',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            onload: (response_data) => {
                                var f_selector = $('input[name="' + name + '"]');
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
    </script>
<script>
    function phoneNumberChk()
    {
        // var gardian_phone = document.getElementById("gardian_phone").value;
        var phone = document.getElementById("phone").value;

        if(phone.length !== 11)
        {
            document.getElementById("phn").textContent = "Invalid Phone number";
            document.getElementById("addTeacher").disabled = true;
            //document.getElementById("phn").css('background-color', 'Red');
            //return false;
        }
        else if(phone.length === 11 && phone.length)
        {
            document.getElementById("phn").textContent = "";
            document.getElementById("addTeacher").disabled = false;

            //return true;
        }
    }

    function phnNumberPost()
    {

        var phone = document.getElementById("phone").value;

        if((phone.length !== 11 || phone === ''))
        {
            document.getElementById("addTeacher").disabled = true;
            document.getElementById("phn").textContent = "Invalid Phone number";
        }
    }
</script>
@endpush
