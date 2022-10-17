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
                            <h4>Attendance</h4>
                        </span>
                    </div>
                    <div class="card-body">
                                @include('partial.flush-message')
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
                                        <p><i class="fas fa-arrow-circle-right"></i> <span>Shift:</span> {{ $minfo->shift->name }}
                                        </p>
                                    </div>
                                    <div class="col-md-5">

                                    </div>
                                    <div class="col-md-3">
                                        <p><i class="fas fa-arrow-circle-down"></i> <span>Group:</span> {{ $minfo->group->name }}
                                        </p>
                                        <p><i class="fas fa-arrow-circle-down"></i> <span>Teacher:</span>
                                            {{ $minfo->teacher->name }}
                                        </p>
                                        <p><i class="fas fa-arrow-circle-down"></i> <span>subject:</span>
                                            {{ $minfo->subject->name }}
                                        </p>
                                        <p><i class="fas fa-arrow-circle-down"></i> <span>Class:</span>
                                            {{ 'Class'.$class}}
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
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 1; $i <=  $minfo->subject->credit->total_class; $i++)
                                                    @if ($i % 2 != 0)
                                                    <tr>
                                                        <td> {{ 'Class ' . $i }}</td>
                                                        <td></td>
                                                        <td><a href="{{route("attendance.create",[$minfo->id,$i])}}"><i class="fas fa-arrow-right"></i></a></td>
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
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 1; $i <= $minfo->subject->credit->total_class; $i++)
                                                        @if ($i % 2 == 0)
                                                            <tr>
                                                                <td> {{ 'Class ' . $i }}</td>
                                                                <td></td>
                                                                <td><a href="{{route("attendance.create",[$minfo->id,$i])}}"><i class="fas fa-arrow-right"></i></a></td>
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
    @endpush
