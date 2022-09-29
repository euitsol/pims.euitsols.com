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
                            <h4>Update Teacher</h4>
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
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <form action="{{ route('teacher.update') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $db_data->id }}">
                                    <div class="form-group row">

                                        <label class="col-sm-8" for="name">Teacher Name<span
                                                class="text-danger">*</span></label>

                                        <label class="col-sm-4" for="name">Photo<span
                                                class="text-danger"></span></label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $db_data->name }}" placeholder="Enter Teacher's Name" required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif

                                            <label class="mt-3" for="department">Department<span
                                                    class="text-danger">*</span></label>

                                            <select class="form-control" name="departments" id="department">
                                                <option value="">Select Department</option>
                                                @foreach ($depts as $department)
                                                    <option value="{{ $department->id }}"
                                                        @if ($department->id == $db_data->departments_id) selected @endif>
                                                        {{ $department->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('department'))
                                                <span class="text-danger">{{ $errors->first('department') }}</span>
                                            @endif

                                        </div>

                                        <div class="col-sm-4">
                                            <input name="uploadfile" data-actualName="image" type="file" id="image"
                                                accept="image/*">
                                            <input type="hidden" name="pre_photo" value="{{$db_data->photo}}">

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
                                                    <option
                                                        value="{{ $divisions->id }}"@if ($divisions->id == $db_data->divisions_id) selected @endif>
                                                        {{ $divisions->name }}
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
                                                    <option
                                                        value="{{ $districts->id }}"@if ($districts->id == $db_data->districts_id) selected @endif>
                                                        {{ $districts->name }}
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
                                                @foreach ($blood_group as $bloodgroup)
                                                    <option
                                                        value="{{ $bloodgroup->id }}"@if ($bloodgroup->id == $db_data->bloodgroups_id) selected @endif>
                                                        {{ $bloodgroup->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('bloodgroup'))
                                                <span class="text-danger">{{ $errors->first('bloodgroup') }}</span>
                                            @endif
                                        </div>

                                        <div class="input-group date col-sm-6" id="reservationdate"
                                            data-target-input="nearest">

                                            <input type="text" name="date_of_birth"
                                                value="{{ $db_data->date_of_birth }}"class="form-control datetimepicker-input"
                                                data-target="#reservationdate" placeholder="Enter Your Date Of Birth">

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
                                                value="{{ $db_data->phone }}" placeholder="Enter Teacher's Phone"
                                                required>
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $db_data->email }}" placeholder="Enter Email Address" required>
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
                                                <option value="Male" @if ($db_data->gender == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female"@if ($db_data->gender == 'Female') selected @endif>
                                                    Female</option>
                                                <option value="Other" @if ($db_data->gender == 'Other') selected @endif>
                                                    Other</option>
                                            </select>
                                            @if ($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" id="nid" name="nid"
                                                value="{{ $db_data->nid }}" placeholder="Enter Teacher's NID">
                                            @if ($errors->has('nid'))
                                                <span class="text-danger">{{ $errors->first('nid') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12" for="name">Present Address<span
                                                class="text-danger"></span></label>
                                        <div class="col-sm-12">
                                            <textarea name="present_address" class="form-control" placeholder="Enter Your Present Address" cols="4">{{ $db_data->present_address }}</textarea>
                                            @if ($errors->has('present_address'))
                                                <span class="text-danger">{{ $errors->first('present_address') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12" for="name">Permanant Address<span
                                                class="text-danger"></span></label>
                                        <div class="col-sm-12">
                                            <textarea name="permanant_address" class="form-control" placeholder="Enter Your Permanant Address" cols="4">{{ $db_data->permanant_address }}</textarea>
                                            @if ($errors->has('permanant_address'))
                                                <span class="text-danger">{{ $errors->first('permanant_address') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-12" for="guard_name"></label>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Add Teacher</button>
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
@endpush
