@extends('layouts.app')

@section('title', 'Course Content Managment')

@push('third_party_stylesheets')
@endpush

@push('page_css')
<style>
    .short-view tr{
line-height: 1px;
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
                            <h4>Class Details (Class-{{$class}})</h4>
                        </span>
                        <span class="float-right">
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="table-responsive">
                                    <table class="table short-view table-borderless table-striped">
                                        <tbody id="view-tbody">
                                            <tr>
                                                <td>Session</td>
                                                <td>:</td>
                                                <td>
                                                    <span>{{ $minfo->session->start . '-' . $minfo->session->end }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Department</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->department->short_name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Semester</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->semester->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Shift</td>
                                                <td>:</td>
                                                <td>
                                                    <span>{{ $minfo->shift->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Group</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->group->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Subject</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->subject->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Class</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ 'Class' . $class }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <form action="">
                            <div class="form-group">
                                <label for="class_contents">Class Contents</label>
                                <input type="text" id="class_contents">
                            </div>
                            <div class="form-group">

                                <label for="files">Files </label>
                                <input type="text" id="files">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('third_party_scripts')
@endpush

@push('page_scripts')
    <script></script>
@endpush
