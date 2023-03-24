@extends('layouts.app')

@section('title', 'Subjects Assign Management')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
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
                            <h4>Assign Subjects</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('subject-assign.index') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <form action="{{ route('subject-assign.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3" for="session_id">Session<span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9 row">
                                            <div class="col-md-11">
                                                <select class="form-control" id="session_id" name="session_id" required>
                                                    <option value="" hidden>Select Session</option>
                                                    @foreach ($session as $n)
                                                        <option value="{{ $n->id }}"
                                                            @if (old('session_id') == $n->id) selected @endif>
                                                            {{ $n->start . '-' . $n->end }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('session_id'))
                                                    <span class="text-danger">{{ $errors->first('session_id') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-1 rounded-0">
                                                @if (Auth::user()->can('subject-assing add') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('session.add') }}" target="_blank"
                                                        class="btn btn-info" title="Assign new Subject"><i
                                                            class="fas fa-plus-square"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-3" for="semester_id">Semester<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9 row">
                                           <div class="col-md-11">
                                            <select class="form-control" id="semester_id" name="semester_id" required>
                                                <option value="" hidden>Select Semester</option>
                                                @foreach ($semester as $n)
                                                    <option value="{{ $n->id }}"
                                                        @if (old('semester_id') == $n->id) selected @endif>
                                                        {{ $n->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('semester_id'))
                                                <span class="text-danger">{{ $errors->first('semester_id') }}</span>
                                            @endif
                                           </div>
                                            <div class="col-md-1 rounded-0">
                                                @if (Auth::user()->can('subject-assing add') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('semester.add') }}" target="_blank"
                                                        class="btn btn-info" title="Assign new Semester"><i
                                                            class="fas fa-plus-square"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="department_id">Department<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9 row">
                                           <div class="col-md-11">
                                            <select class="form-control" id="department_id" name="department_id" required>
                                                <option value="" hidden>Select Department</option>
                                                @foreach ($department as $n)
                                                    <option value="{{ $n->id }}"
                                                        @if (old('department_id') == $n->id) selected @endif>
                                                        {{ $n->department_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('department_id'))
                                                <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                            @endif
                                           </div>
                                            <div class="col-md-1 rounded-0">
                                                @if (Auth::user()->can('subject-assing add') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('department.create') }}" target="_blank"
                                                        class="btn btn-info" title="Assign new Department"><i
                                                            class="fas fa-plus-square"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="subject_id">Subjects<span
                                                class="text-danger">*</span></label>
                                       <div class="col-md-9 row">
                                        <div class="select2-purple col-md-11">
                                            <select class="select2 select2-hidden-accessible" multiple=""
                                                data-placeholder="Select Subjects" data-dropdown-css-class="select2-purple"
                                                style="width: 100%;" id="subject_id" name="subject_id[]" tabindex="-1"
                                                aria-hidden="true" disabled required>
                                                <option value="" hidden>Select Subject</option>
                                            </select>
                                            @if ($errors->has('subject_id.*'))
                                                <span class="text-danger">{{ $errors->first('subject_id.*') }}</span>
                                            @endif
                                        </div>
                                       </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-3" for="guard_name"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary w-100">Assign</button>
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
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>

        //select2 tools
        $(document).ready(function() {
            $('.select2').select2();
        });

        //reset department on session change
        $("#session_id").change(function() {
            $('#department_id').prop('selectedIndex', 0);
            $("#subject_id").prop('disabled', true);
        });

        //reset department on semester change
        $("#semester_id").on('change', function() {
            $('#department_id').prop('selectedIndex', 0);
            $('#subject_id').prop('selectedIndex', 0);
            $("#subject_id").prop('disabled', true);

        });

        //Fetch subject on department change
        $("#department_id").on('change', function() {
            $("#subject_id").prop('disabled', false);
            $('#subject_id').val('').trigger('change');
            // $('#semester_id').val('').trigger('change');

            var department_id = $(this).val();
            var subject_id = $('#subject_id').val();
            var session_id = $('#session_id').val();
            var semester_id = $('#semester_id').val();

            //Session validation
            if (session_id == '') {
                alert('You have to select Session');
                return false;
            }
            //Semester validation
            if (semester_id == '') {
                alert('You have to select Semester');
                return false;
            }
            var url = "{{route('subject-fetch.ajax')}}";

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    'department_id': department_id,
                    'semester_id': semester_id,
                    'session_id': session_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    // console.log(response);
                    var data = '<option value="" hidden>Select Subject</option>'
                    $.each(response, function(index, value) {
                        data += '<option value="' + value.id + '" class= "' + value.result +
                            '">' + value.name + '</option>';
                    });

                    $('#subject_id').html(data);
                    $('#subject_id .true').prop('disabled', true);

                }
            });
        });
    </script>
@endpush
