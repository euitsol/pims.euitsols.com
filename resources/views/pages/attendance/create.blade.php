@extends('layouts.app')

@section('title', 'Attendance Management')
@push('third_party_stylesheets')
    <link href="{{ asset('assets/css/icheck-bootstrap/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">

@endpush

@push('page_css')
    <style>
        .info p i {
            color: #fb00ff;
            font-size: 15px;
        }
        .info p span {
            font-weight: 800;
            font-size: 15px;
            color: blue;
        }

        .info {
            margin-bottom: 25px;
            font-size: 17px;
        }

        .info p {
            margin-bottom: 1px !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class" value="{{ $class }}">
                    <input type="hidden" name="attendance_id" value="{{ $minfo->id }}">
                    <div class="card">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Attendance</h4>
                            </span>
                            <span class="float-right">
                                @if (Auth::user()->can('user view') || Auth::user()->role->id == 1)
                                    <a href="{{ route('attendance.class',$minfo->id) }}" class="btn btn-info">Back</a>
                                @endif
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="info row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <p><i class="fas fa-arrow-circle-down"></i><span> Session: </span>
                                        {{ $minfo->session->start . '-' . $minfo->session->end }}</p>
                                    <p><i class="fas fa-arrow-circle-down"></i> <span> Department: </span>
                                        {{ $minfo->department->short_name }}</p>
                                    <p><i class="fas fa-arrow-circle-down"></i> <span> Semester: </span>
                                        {{ $minfo->semester->name }}</p>
                                    <p><i class="fas fa-arrow-circle-right"></i> <span>Shift:</span>
                                        {{ $minfo->shift->name }}
                                    </p>
                                </div>
                                <div class="col-md-5">
                                </div>
                                <div class="col-md-3">
                                    <p><i class="fas fa-arrow-circle-down"></i> <span>Group:</span>
                                        {{ $minfo->group->name }}
                                    </p>
                                    <p><i class="fas fa-arrow-circle-down"></i> <span>Total student:</span>
                                        {{ $minfo->totalStudent() }}
                                    </p>
                                    <p><i class="fas fa-arrow-circle-down"></i> <span>Teacher:</span>
                                        {{ $minfo->teacher->name }}
                                    </p>
                                    <p><i class="fas fa-arrow-circle-down"></i> <span>Subject:</span>
                                        {{ $minfo->subject->name }}
                                    </p>
                                    <p><i class="fas fa-arrow-circle-down"></i> <span>Class:</span>
                                        {{ 'Class' . $class }}
                                    </p>
                                </div>
                            </div>
                            <div class="row justify-center">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <input type="text" name="date" class="form-control date text-center"
                                        placeholder="Select Date" autocomplete="off"
                                        value="{{ $attendance_taken->date ?? '' }}">
                                        @if ($errors->has('date'))
                                        <span class="text-danger text-center">{{ $errors->first('date') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4">

                                </div>
                            </div>
                            <div class="table table-responsive">
                                <table id="table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Student Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key => $student)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $student->studentInfo->student_id }}</td>
                                                <td>{{ $student->studentInfo->name }}</td>
                                                <td>{{ $student->studentInfo->phone }}</td>
                                                <input type="hidden" name="student[{{ $key }}][id]"
                                                    value="{{ $student->studentInfo->id }}">
                                                <td>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio"
                                                            name="student[{{ $key }}][attendance]"
                                                            id="attendance_check_{{ $key }}" value="1"
                                                            checked>
                                                        <label for="attendance_check_{{ $key }}">P </label>
                                                    </div>
                                                    <div class="icheck-danger d-inline">&nbsp;
                                                        <input type="radio"
                                                            name="student[{{ $key }}][attendance]"
                                                            id="attendance_check_a{{ $key }}" value="-1"
                                                            @isset($attendance_taken) @if ($attendance_taken->attendance($minfo->id, $student->studentInfo->id)) checked @endif
                                                            @endisset>
                                                        <label for="attendance_check_a{{ $key }}"> A</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-center">
                            <button type="submit" class="btn btn-success">Save Attendance</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $('.date').datepicker({
            autoclose: true,
            minDate : new Date(),
        });

        $(document).ready(function(){
            let date_time = new Date();
            let date = date_time.getDate();
            let month = date_time.getMonth()+1;
            let year = date_time.getFullYear();
            var current_date = date+'/'+month+'/'+year;
            console.log(date_time.getMonth());
        });
    </script>
@endpush
