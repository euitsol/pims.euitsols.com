@extends('layouts.app')

@section('title', 'Semester-Duration Management')

@push('third_party_stylesheets')
<link href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}" rel="stylesheet"/>
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
                        <h4>Edit Semester Duration</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('semester duration view') || Auth::user()->role->id == 1)<a href="{{ route('semesterDuration.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('semesterDuration.edit.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{ $semester_session->id }}">
                                <div class="form-group row">
                                    <label class="col-sm-3" for="session">Session<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 row">
                                        <div class="col-md-11">
                                            <select class="form-control" id="session" name="session" required>
                                                <option value="" hidden>Select session</option>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id }}" @if( $session->id == $semester_session->session->id ) selected @endif>{{ $session->start }} - {{ $session->end }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('session'))
                                                <span class="text-danger">{{ $errors->first('session') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-1 rounded-0">
                                            @if(Auth::user()->can('session add') || Auth::user()->role->id == 1)<a href="{{ route('session.add') }}" target="_blank" class="btn btn-info" title="Add new session"><i class="fas fa-plus-square"></i></a>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none;" id="previous_duration">
                                    <label class="col-sm-3" for="start_month">Semester Durations</label>
                                    <div class="col-sm-9">
                                        <table class="table table-borderless table-hover" id="previous_duration_table">
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="semester">Semester<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 row">
                                        <div class="col-md-11">
                                            <select class="form-control" id="semester" name="semester" required>
                                                <option value="" hidden >Select semester</option>
                                                @foreach($semesters as $semester)
                                                    <option value="{{ $semester->id }}" @if( $semester->id == $semester_session->semester->id ) selected @endif>{{ $semester->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('semester'))
                                                <span class="text-danger">{{ $errors->first('semester') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-1 rounded-0">
                                            @if(Auth::user()->can('semester add') || Auth::user()->role->id == 1)<a href="{{ route('semester.add') }}" target="_blank" class="btn btn-info" title="Add new semester"><i class="fas fa-plus-square"></i></a>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="start_month">Duration<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-daterange" id="year">
                                            <input type="text" class="form-control" id="start_month" name="start_month" value="{{ date('M Y', strtotime($semester_session->start)) }}">
                                        <div class="input-group-append"><div class="input-group-text">to</div></div>
                                            <input type="text" class="form-control" id="end_month" name="end_month" value="{{ date('M Y', strtotime($semester_session->end)) }}">
                                        </div>
                                        @if ($errors->has('start_month'))
                                            <span class="text-danger">{{ $errors->first('start_month') }}</span>
                                        @endif
                                        @if ($errors->has('end_month'))
                                            <span class="text-danger">{{ $errors->first('end_month') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="create"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary w-100">Update</button>
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
<script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>
@endpush

@push('page_scripts')
<script>

$(document).ready(function() {
    if( $('#session').val() != null && $('#session').val() != '' ){
        get_previous_durations($('#session').val());
    }

    $('#start_month').datepicker({
        autoclose: true,
        format: "MM yyyy",
        startView: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true,
    });

    $('#end_month').datepicker({
        autoclose: true,
        format: "MM yyyy",
        startView: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true,
    });

    $('#session').change( function(){
        if($('#session').val() != null && $('#session').val() != ''){
            get_previous_durations($('#session').val());
        }
    });
});

function get_previous_durations(session_id){
    let url = ("{{ route('semesterDuration.duration', ['session_id']) }}");
    let _url = url.replace('session_id', session_id);
    $.ajax({
        url: _url,
        method: "GET",
        success: function (response) {
            let result ='';
            if(response.length > 0){
                for (data of response){
                    if(data.id != {{ $semester_session->id }})
                    result += `
                        <tr>
                            <td>Semester: ${data.semester.name}</td>
                            <td>Session: ${data.session.start} - ${data.session.end}</td>
                            <td>Duration: ${get_month_name(new Date(data.start).getMonth() + 1)}-${new Date(data.start).getFullYear()} - ${get_month_name(new Date(data.end).getMonth() + 1)}-${new Date(data.end).getFullYear()}</td>
                        </tr>
                    `;
                }
            }else{
                result +='<tr><td> No previous data </td></tr>';
            }
            $('#previous_duration').show();
            $('#previous_duration_table tbody').html(result);
        }
    });
}

</script>
@endpush

