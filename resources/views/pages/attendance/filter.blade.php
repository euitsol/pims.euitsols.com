@extends('layouts.app')

@section('title', 'Attendance Management')

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
                            <h4>Attendance</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{route('attendance.filter.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="semester_id" value="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="session_id">Session</label>
                                        <select name="session_id" class="form-control select" id="session_id">
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
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control select" id="department_id">
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
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="semester_id">Semester</label>
                                        <select name="semester_id" class="form-control select" id="semester_id">
                                            <option value="" hidden>Select Semester</option>
                                            @foreach ($semester as $n)
                                                <option value="{{ $n->id }}"
                                                    @if (old('semester_id') == $n->id) selected @endif>{{ $n->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('semester_id'))
                                            <span class="text-danger">{{ $errors->first('semester_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="shift_id">Shift</label>
                                        <select name="shift_id" id="shift_id" class="form-control select" >
                                            <option value="" hidden>Select Shift</option>
                                            @foreach ($shift as $n)
                                                <option value="{{ $n->id }}"
                                                    @if (old('shift_id') == $n->id) selected @endif>{{ $n->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('shift_id'))
                                            <span class="text-danger">{{ $errors->first('shift_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="group_id">Group</label>
                                        <select name="group_id" id="group_id" class="form-control select" >
                                            <option value="" hidden>Select Group</option>
                                            @foreach ($group as $n)
                                                <option value="{{ $n->id }}"
                                                    @if (old('group_id') == $n->id) selected @endif>{{ $n->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('group_id'))
                                            <span class="text-danger">{{ $errors->first('group_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" id="teacher_div">
                                        <label for="teacher_id">Teacher</label>
                                        <select name="teacher_id" id="teacher_id" class="form-control select" >
                                            <option value="" hidden>Select Teacher</option>
                                        </select>
                                        @if ($errors->has('teacher_id'))
                                            <span class="text-danger">{{ $errors->first('teacher_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" id="subject_div">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-control select" >
                                            <option value="" hidden>Select Subject</option>
                                        </select>
                                        @if ($errors->has('subject_id'))
                                        <span class="text-danger">{{ $errors->first('subject_id') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('third_party_scripts')
    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {

            $('.select').select2();
            // teacher validation
            $('#teacher_div').click(function(){
                if($('#department_id').val()==''){
                    alert('Select Department');
                    return;
                }
            });

            // Subject Validation
             $('#subject_div').click(function(){
                if($('#session_id').val()==''){
                    alert('Select Session');
                    return;
                }
                if($('#department_id').val()==''){
                    alert('Select Department');
                    return;
                }
                if($('#semester_id').val()==''){
                    alert('Select Semester');
                    return;
                }
            });

            //Teacher fetch according to Department
            $("#department_id").change(function() {
                var department_id = $(this).val();
                teacherFetch(department_id);
            });
            var old_teacher_id = '{{old('teacher_id') ?? ''}}';

            if(old_teacher_id != ''){
                console.log('old_teacher_id')
                teacherFetch(old_teacher_id);
                $('#teacher_id').val({{old('teacher_id')}}).trigger('change.select2');
            }

            $("#session_id, #department_id, #semester_id").change(function() {

                var session_id = $('#session_id').val();
                var department_id = $('#department_id').val();
                var semester_id = $('#semester_id').val();
                subjectFetch(session_id,department_id,semester_id);
            });

            var old_subject_id = '{{old('subject_id') ?? ''}}';
            if(old_subject_id != ''){
                var session_id = $('#session_id').val();
                var department_id = $('#department_id').val();
                var semester_id = $('#semester_id').val();
                subjectFetch(session_id,department_id,semester_id);
                $('#subject_id').val({{old('subject_id')}}).trigger('change.select2');
            }
        });

        function teacherFetch(department_id){
            $.ajax({
                url: "{{ route('teacher_fetch.ajax') }}",
                method: 'GET',
                async:false,
                data: {
                    department_id: department_id,
                },
                success: function(response) {
                    var option = "<option value='' hidden>Select Teacher</option>";
                    $.each(response, function(index, value) {
                        option += `
                        <option value="${value.id}">${value.name}</option>
                        `;
                    });
                    $('#teacher_id').html(option);
                }
            });
        }


        //Subject fetch according to session, department, semester
        // $("#session_id, #department_id, #semester_id").change(function() {
            function subjectFetch(session_id,department_id,semester_id){
            var session_id = session_id;
            var department_id = department_id;
            var semester_id = semester_id;
            $.ajax({
                url: "{{ route('subject_assign_fetch.ajax') }}",
                method: 'GET',
                async:false,
                data: {
                    session_id: session_id,
                    department_id: department_id,
                    semester_id: semester_id,
                },
                success: function(response) {
                    var option = "<option value='' hidden>Select Subject</option>";
                    $.each(response, function(index, value) {
                        option += `
                        <option value="${value.subject.id}">${value.subject.name}</option>
                        `;
                    });
                    $('#subject_id').html(option);
                }
            });
            }
        // });

    </script>
@endpush
