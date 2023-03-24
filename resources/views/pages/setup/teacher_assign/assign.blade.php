@extends('layouts.app')

@section('title', 'Teacher Assign Management')

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
                            <h4>Assign Teacher</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('teacher-assign.index') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>

                    @php
                        $data = $minfo->first();
                    @endphp
                    <div class="card-body">
                        <div>
                            <p><span>⬇️</span><strong>Session: </strong>{{$data->subjectAssign->session->start.'-'.$data->subjectAssign->session->end}} </p>
                            <p><span>⬇️</span><strong>Department: </strong>{{$data->subjectAssign->department->department_name}}</p>
                            <p><span>⬇️</span><strong>Semester: </strong>{{$data->subjectAssign->semester->name}}</p>
                        </div>

                         @include('partial.flush-message')
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <form action="{{route('teacher-assign.assign-store')}}" method="POST" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="subject_assign_id" value="{{$data->subjectAssign->id}}">
                                    @php
                                    $count = 0;
                                    @endphp
                                        <div class="shadow-lg p-3 mb-5 bg-body rounded">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Subject Name : </strong><span>{{ $data->subjectAssign->subject->name}}</span></span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Subject Code : </strong><span>{{ $data->subjectAssign->subject->code}}</span></span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Credit :</strong> <span>{{ $data->subjectAssign->subject->credit->credit_number }}</span></span>
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-4 text-center">
                                                    <span>
                                                    <strong> Marks : </strong>{{$data->subjectAssign->subject->credit->marks}}</span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Class Time : </strong> {{$data->subjectAssign->subject->credit->class_hour.':'.$data->subjectAssign   ->subject->credit->hour_minute}}</span>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <span><strong>Total Class : </strong>    {{$data->subjectAssign->total_class}}</span>
                                                </div>
                                            </div>

                                            <hr>

                                            {{-- Teacher  --}}
                                            <h5 class="text-center text-primary">Assign Teacher</h5>
                                            @foreach ( $minfo as $key => $mvalue)
                                                    @php
                                                        $div_identifier = rand(0,100);

                                                    @endphp
                                                {{-- Teacher  --}}
                                                <div class="form-group row" id="div_{{$div_identifier}}">
                                                    <div class="col-sm-1 text-right">
                                                        <label for="teacher_id">Teacher<span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="teacher_id" name="teacher_assign[{{$count}}][teacher_id]" required>
                                                            <option value="" hidden>Select Teacher</option>
                                                            @foreach ($teacher as $value)
                                                                <option value="{{$value->id}}"
                                                                    @if ($mvalue->teacher_id == $value->id) selected @endif>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
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
                                                        <select class="form-control" id="group" name="teacher_assign[{{$count}}][group_id]" required>
                                                            <option value="" hidden>Select Group</option>
                                                            @foreach ($group as $value)
                                                                <option value="{{ $value->id}}"
                                                                    @if ($mvalue->group_id == $value->id) selected @endif>
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
                                                        <select class="form-control" id="shift_id" name="teacher_assign[{{$count}}][shift_id]" required>
                                                            <option value="" hidden>Select Shift</option>
                                                            @foreach ($shift as $value)
                                                                <option value="{{ $value->id }}"
                                                                    @if ($mvalue->shift_id == $value->id) selected @endif>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('shift_id'))
                                                            <span class="text-danger">{{ $errors->first('shift_id') }}</span>
                                                        @endif
                                                    </div>

                                                    {{-- Plus Minus button  --}}
                                                    @if ($key == 0)
                                                        <div class="col-sm-1">
                                                            <button type="button" class="btn btn-success add-more float-right" data-subject_assign_id="{{$mvalue->id}}"><i class="nav-icon fas fa-plus"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-1">
                                                            <button type="button" class="btn btn-danger reduce float-right" onclick="delete_section({{$div_identifier}})"><i class="nav-icon fas fa-minus"></i></button>
                                                        </div>
                                                    @endif
                                                </div>
                                                @php
                                                    $count++;
                                                @endphp
                                                 {{-- Append Option  --}}
                                            <div class="append" id="append{{$loop->index}}">

                                            </div>
                                            @endforeach

                                        </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3" for="guard_name"></label>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Assign</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="count" id="count" value="{{$count}}">
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
            function delete_section(count){
            $('#div_'+count).remove();

        }
        });

        $('.add-more').each(function(index){
            $(this).click(function(){

                var count = Number($('#count').val())+1;
                var sid = Number($(this).data('subject_assign_id'))

                $('#count').val(count);
                var div_identifier = Date.now();
                // alert(div_identifier);
                var option = `
                                <div class="form-group row " id='div_${div_identifier}'>
                                    <input type="hidden" name="teacher_assign[${count}][subject_assign_id]" value="${sid}">
                                    <div class="col-md-1 text-right">
                                        <label for="teacher_id">Teacher<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="teacher_id" name="teacher_assign[${count}][teacher_id]" required>
                                            <option value="" hidden>Select Teacher</option>
                                                @foreach ($teacher as $value)
                                                    <option value="{{$value->id}}"  @if ( old('group') == $value->id) selected @endif> {{ $value->name }}</option>
                                                @endforeach
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
                                        <select class="form-control" id="group" name="teacher_assign[${count}][group_id]" required>
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
                                        <select class="form-control" id="shift_id" name="teacher_assign[${count}][shift_id]" required>
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

    </script>
@endpush
