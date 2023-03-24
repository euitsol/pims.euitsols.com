@extends('layouts.app')

@section('title', 'Class Content Managment')

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

        .ck-editor__editable_inline {
            min-height: 70vh;
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
                            <h4>Class Details (Class-{{ $class }})</h4>
                        </span>
                        <span class="float-right">
                            @if (Auth::user()->can('user view') || Auth::user()->role->id == 1)
                                <a href="{{ route('attendance.create',[$attendance_id,$class]) }}" class="btn btn-info">Back</a>
                            @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <form action="{{ route('class_content.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="std_attendance_id" value="{{ $minfo->id }}">
                                    <input type="hidden" name="class" value="{{ $class }}">
                                    <input type="hidden" name="attendance_id" value="{{ $attendance_id }}">
                                    <div class="row justify-content-center">
                                        <div class="col-md-10">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Class Content: </label>
                                                <textarea name="class_content" class="form-control ckeditor" rows="8" placeholder="Enter class content here"
                                                    cols="6" >@if(isset($class_content->class_content)) {!! $class_content->class_content !!} @endif</textarea>
                                                @if ($errors->has('class_content'))
                                                    <span class="text-danger">{{ $errors->first('class_content') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mb-4 justify-content-center">
                                        <div class="col-md-10">
                                            <!-- textarea -->
                                            <label for="">Upload Files:</label>
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input"
                                                    id="customFile" multiple>
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-4 justify-content-center">
                                        <div class="col-md-10">
                                            <div class="float-right">
                                                <button class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <div class="table-responsive">
                                    <table class="table short-view table-borderless table-striped">
                                        <tbody id="view-tbody">
                                            <tr>
                                                <td>Session</td>
                                                <td>:</td>
                                                <td>
                                                    <span>{{ $minfo->attendances->session->start . '-' . $minfo->attendances->session->end }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Department</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->attendances->department->short_name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Semester</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->attendances->semester->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Shift</td>
                                                <td>:</td>
                                                <td>
                                                    <span>{{ $minfo->attendances->shift->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Group</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->attendances->group->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Subject</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->attendances->subject->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Teacher</td>
                                                <td>:</td>
                                                <td>
                                                    <span> {{ $minfo->attendances->teacher->name }}</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/ckeditor/build/ckeditor.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        ClassicEditor.create(document.querySelector('.ckeditor'))
        $(document).ready(function(){
            @if ($errors->has('class_content'))
                toastr.error("Please, enter class content");
            @endif
            @if ($errors->has('student.*.id'))
                toastr.error("There is no student");
            @endif
        });
    </script>

    <script>
        $('#customFile').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                var j;
                for(var i = 0; i < fileName.length; i++)
                {
                    if(fileName[i] == "\\")
                    {
                        j = i;
                    }
                }
                var fileNameModify = "";
                for(var i = j + 1; i < fileName.length; i++)
                {
                    fileNameModify += fileName[i];
                }
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileNameModify);
            })
    </script>
@endpush
