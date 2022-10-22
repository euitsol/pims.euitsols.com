@extends('layouts.app')

@section('title', 'Class content Mangement')

@push('third_party_stylesheets')

@endpush

@push('page_css')
<style>
    .short-view tr {
        line-height: 1px;
    }

    .custom-card {
        margin: 0px auto;
        width: 60%;
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
                        <h4>Class Content</h4>
                    </span>
                    <span class="float-right">
                        @if (Auth::user()->can('user view') || Auth::user()->role->id == 1)
                            <a href="{{ route('class_content.create',[$attendance_id,$class])}}" class="btn btn-info">Edit</a>
                        @endif
                    </span>

                </div>
                <div class="card-body">
                    @php
                    $minfo =  $class_content->first();
                 @endphp
                <div class="row">
                    <div class="col-md-3 offset-md-9">
                        <div class="table-responsive">
                            <table class="table short-view table-borderless table-striped">
                                <tbody id="view-tbody">
                                    <tr>
                                        <td>Session</td>
                                        <td>:</td>
                                        <td>
                                            <span>{{ $minfo->stdAttendance->attendances->session->start . '-' . $minfo->stdAttendance->attendances->session->end }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td>:</td>
                                        <td>
                                            <span> {{ $minfo->stdAttendance->attendances->department->short_name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Semester</td>
                                        <td>:</td>
                                        <td>
                                            <span> {{ $minfo->stdAttendance->attendances->semester->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shift</td>
                                        <td>:</td>
                                        <td>
                                            <span>{{ $minfo->stdAttendance->attendances->shift->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Group</td>
                                        <td>:</td>
                                        <td>
                                            <span> {{ $minfo->stdAttendance->attendances->group->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Subject</td>
                                        <td>:</td>
                                        <td>
                                            <span> {{ $minfo->stdAttendance->attendances->subject->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Class</td>
                                        <td>:</td>
                                        <td>
                                            <span> {{ 'Class' . $minfo->class }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    @foreach ($class_content as $class_content)
                    {!! $class_content->class_content !!}

                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('third_party_scripts')

@endpush

@push('page_scripts')
<script>

</script>
@endpush

