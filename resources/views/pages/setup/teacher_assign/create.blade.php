@extends('layouts.app')

@section('title', 'Teacher Assign Management')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('page_css')
    <style>
        .select2-container--default .select2-search--inline .select2-search__field {
            border: none !important;
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
                            <h4>Assign Teacher</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('subject-assign.index') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <div>
                            <p><span>⬇️</span><strong>Session: </strong>{{$sds->session->start.'-'.$sds->session->start}} </p>
                            <p><span>⬇️</span><strong>Department: </strong>{{$sds->department->department_name}}</p>
                            <p><span>⬇️</span><strong>Semester: </strong>{{$sds->semester->name}}</p>

                        </div>

                               @include('partial.flush-message')
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <form action="{{route('teacher-assign.store')}}" method="POST" class="form-horizontal">
                                    @csrf
                                    @foreach ($data as $value)
                                        <div class="shadow-lg p-3 mb-5 bg-body rounded">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Subject Name : </strong><span>{{ $value->subject->name}}</span></span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Subject Code : </strong><span>{{ $value->subject->code}}</span></span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Credit :</strong> <span>{{ $value->subject->credit->credit_number }}</span></span>
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-4 text-center">
                                                    <span>
                                                    <strong> Marks : </strong>{{$value->subject->credit->marks}}</span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Class Time : </strong> {{$value->subject->credit->class_hour.':'.$value->subject->credit->hour_minute}}</span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Total Class : </strong>    {{$value->total_class}}</span>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-md-4 text-right">
                                                    <label for="teacher_id">Teacher<span class="text-danger">*</span></label>
                                                </div>
                                                <input type="hidden" name="teacher_assign[{{$loop->index}}][aubjec_assign_id]">
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="teacher_id" name="teacher_assign[{{$loop->index}}][teacher_id]" required>
                                                        <option value="" hidden>Select Teacher</option>
                                                        @foreach ($teacher as $value)
                                                            <option value="{{ $value }}"
                                                                @if (old('teacher_id') == $value) selected @endif>
                                                                {{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('teacher_id'))
                                                        <span class="text-danger">{{ $errors->first('teacher_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group row">
                                        <label class="col-sm-3" for="guard_name"></label>
                                        <div class="col-sm-12">
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

            var url = "<?php echo url('/subject-fetch'); ?>/";

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
