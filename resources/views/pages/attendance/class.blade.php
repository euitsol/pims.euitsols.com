@extends('layouts.app')

@section('title', 'Attendance Management')

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

        .card1 {
            width: 49%;
            margin-right: 5px;
        }

        .card2 {
            width: 49%;
            margin-left: 5px;
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
                            <h4>Classes for {{ $minfo->subject->name }}</h4>
                        </span>
                        <span class="float-right">
                            @if (Auth::user()->can('user view') || Auth::user()->role->id == 1)
                                <a href="{{ route('attendance.filter') }}" class="btn btn-info">Back</a>
                            @endif
                        </span>

                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')
                        @if (isset($present))
                            <div class="row">
                                <div class="col-md-4 offset-md-4 text-center">
                                    <div class="alert alert-success">
                                        <p class="text-warning">Recently Assigned</p>
                                        <p>Class{{ $class }}</p>
                                        <p>Date: {{ $date }}</p>
                                        <p> Present Students: {{ $present }} </p>
                                        <p> Absent Students: {{ $absent }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                <p><i class="fas fa-arrow-circle-down"></i> <span>Credit:</span>
                                    {{ $minfo->subject->credit->credit_number }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex w-100">
                            <div class="card card1">
                                <div class="table table-responsive">
                                    <table id="table">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Date</th>
                                                <th class="text-center">Attendance</th>
                                                <th class="text-center">Class content</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i <= $minfo->subject->credit->total_class; $i++)
                                                @if ($i % 2 != 0)
                                                    <tr>
                                                        <td> {{ 'Class ' . $i }}</td>
                                                        <td>{{ $minfo->getDate($i)->date ?? '' }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="btn btn-sm @if (isset($minfo->getDate($i)->date)) btn-info @else btn-warning @endif">{{ $minfo->countStd($minfo->semester->id) ?? '' }}/{{ $minfo->countPresentStd($i) ?? '' }}</span>
                                                            <a class="btn btn-sm btn-success" title="Click for attendance"
                                                                href="{{ route('attendance.create', [$minfo->id, $i]) }}"><i
                                                                    class="fas fa-arrow-right text-white"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($minfo->classContentCheck($i))
                                                                <a href="{{ route('class_content.index', [$minfo->id, $i]) }}"
                                                                    class="btn btn-sm btn-info"
                                                                    title="View of class Content"> <i
                                                                        class="fas fa-info"></i>
                                                                </a>
                                                            @elseif($minfo->attendanceCheck($i))
                                                                <a href="{{ route('class_content.create', [$minfo->id, $i]) }}"
                                                                    class="btn btn-sm btn-success"
                                                                    title="Add class Content"> <i class="fas fa-info"></i>
                                                                </a>
                                                            @else
                                                                <button class="btn btn-sm btn-warning take_attendance"
                                                                    title="Please, take attendance first"> <i
                                                                        class="fas fa-info"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card card2">
                                <div class="table table-responsive">
                                    <table id="table">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Date</th>
                                                <th class="text-center">Attendance</th>
                                                <th class="text-center">Class content</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i <= $minfo->subject->credit->total_class; $i++)
                                                @if ($i % 2 == 0)
                                                    <tr>
                                                        <td> {{ 'Class ' . $i }}</td>
                                                        <td>{{ $minfo->getDate($i)->date ?? '' }}</td>
                                                        <td class="text-center">

                                                            <span
                                                                class="btn btn-sm @if (isset($minfo->getDate($i)->date)) btn-info @else btn-warning @endif">{{ $minfo->countStd($minfo->semester->id) ?? '' }}/{{ $minfo->countPresentStd($i) ?? '' }}</span>

                                                            <a class="btn btn-sm btn-success" title="Click for attendance"
                                                                href="{{ route('attendance.create', [$minfo->id, $i]) }}"><i
                                                                    class="fas fa-arrow-right text-white"></i></a>

                                                        </td>
                                                        <td class="text-center">
                                                            @if ($minfo->classContentCheck($i))
                                                                <a href="{{ route('class_content.index', [$minfo->id, $i]) }}"
                                                                    class="btn btn-sm btn-info"
                                                                    title="View of class Content"> <i
                                                                        class="fas fa-info"></i>
                                                                </a>
                                                            @elseif($minfo->attendanceCheck($i))
                                                                <a href="{{ route('class_content.create', [$minfo->id, $i]) }}"
                                                                    class="btn btn-sm btn-success"
                                                                    title="Add class Content"> <i class="fas fa-info"></i>
                                                                </a>
                                                            @else
                                                                <button class="btn btn-sm btn-warning take_attendance"
                                                                    title="Please, take attendance first"> <i
                                                                        class="fas fa-info"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('page_scripts')
        <script>
            $(document).ready(function() {
                $('.take_attendance').click(function() {
                    toastr.error("Please, take attendance first");
                });
            });
        </script>
    @endpush
