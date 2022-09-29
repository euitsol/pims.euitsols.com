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
                    @dd($exist_mifo)
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
                                    {{-- <input type="hidden" name="subjects[i]"> --}}
                                    @php

                                    $count = 0;
                                    @endphp
                                    @foreach ($data as $value)
                                            @php
                                                $count++;
                                            @endphp
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

                                            {{-- Teacher  --}}
                                            <input type="hidden" name="subject_assign[{{$loop->index}}]" value="{{$value->id}}">
                                            <h5 class="text-center text-primary">Assign Teacher</h5>
                                            <div class="form-group row">
                                                <div class="col-sm-1 text-right">
                                                    <label for="teacher_id">Teacher<span class="text-danger">*</span></label>
                                                   </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="teacher_id" name="subjec_assign_id[{{$loop->index}}][0][teacher_id]" required>
                                                        <option value="" hidden>Select Teacher</option>
                                                        <option value="1">Teacher1</option>
                                                        <option value="2">Teacher2</option>
                                                        {{-- @foreach ($teacher as $value)
                                                            <option value="1"
                                                                @if (old('teacher_id') == $value) selected @endif>
                                                                {{ $value }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                    @if ($errors->has('teacher_id'))
                                                        <span class="text-danger">{{ $errors->first('teacher_id') }}</span>
                                                    @endif
                                                </div>

                                                {{-- Group  --}}

                                                <div class="col-sm-1 text-right">
                                                    <label for="group_id">Group<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="group" name="subjec_assign_id[{{$loop->index}}][0][group]" required>
                                                        <option value="" hidden>Select Group</option>
                                                        @foreach ($group as $value)
                                                            <option value="{{ $value->id}}"
                                                                @if (old('group') == $value->name) selected @endif>
                                                                {{ $value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('group'))
                                                        <span class="text-danger">{{ $errors->first('group') }}</span>
                                                    @endif
                                                </div>

                                                {{-- shift  --}}
                                                <div class="col-sm-1 text-right">
                                                    <label for="shift_id">Shift<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="shift_id" name="subjec_assign_id[{{$loop->index}}][0][shift_id]" required>
                                                        <option value="" hidden>Select Shift</option>
                                                        @foreach ($shift as $value)
                                                            <option value="{{ $value->id }}"
                                                                @if (old('shift_id') == $value->name) selected @endif>
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('shift_id'))
                                                        <span class="text-danger">{{ $errors->first('shift_id') }}</span>
                                                    @endif
                                                </div>

                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-success add-more float-right" value="0"><i class="nav-icon fas fa-plus"></i></button>
                                                </div>

                                            </div>
                                            {{-- Append Option  --}}
                                            <div class="append" id="append{{$loop->index}}">

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

        $('.add-more').each(function(index){
            $(this).click(function(){
                var count = Number($(this).val())+1;
                $(this).val(count);
                var div_identifier = Date.now();
                // alert(div_identifier);
                var option = `
                                <div class="form-group row " id='div_${div_identifier}'>
                                    <div class="col-md-1 text-right">
                                        <label for="teacher_id">Teacher<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="teacher_id" name="subjec_assign_id[${index}][${count}][teacher_id]" required>
                                            <option value="" hidden>Select Teacher</option>
                                            <option value="1">Teacher1</option>
                                            <option value="2">Teacher2</option>
                                        </select>
                                        @if ($errors->has('teacher_id'))
                                            <span class="text-danger">{{ $errors->first('teacher_id') }}</span>
                                        @endif
                                    </div>
                                    {{-- Group  --}}
                                    <div class="col-md-1 text-right">
                                        <label for="group_id">Group<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" id="group" name="subjec_assign_id[${index}][${count}][group]" required>
                                            <option value="" hidden>Select Group</option>
                                            @foreach ($group as $value)
                                                <option value="{{ $value->id}}"
                                                    @if (old('group') == $value->name) selected @endif>
                                                    {{ $value->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('group'))
                                            <span class="text-danger">{{ $errors->first('group') }}</span>
                                        @endif
                                    </div>
                                    {{-- shift  --}}
                                    <div class="col-md-1 text-right">
                                        <label for="shift_id">Shift<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" id="shift_id" name="subjec_assign_id[${index}][${count}][shift_id]" required>
                                            <option value="" hidden>Select Shift</option>
                                            @foreach ($shift as $value)
                                                <option value="{{ $value->id }}"
                                                    @if (old('shift_id') == $value->name) selected @endif>
                                                    {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('shift_id'))
                                            <span class="text-danger">{{ $errors->first('shift_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-danger reduce float-right" value="0" onclick="delete_section(${div_identifier})"><i class="nav-icon fas fa-minus"></i></button>
                                    </div>
                                </div>`;
                $('#append'+index).append(option);
                // console.log(index);
            })

        });


         function delete_section(count){
            $('#div_'+count).remove();

        }



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
