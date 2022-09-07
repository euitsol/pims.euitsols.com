@extends('layouts.app')

@section('title', 'Session Management')

@push('third_party_stylesheets')
<link href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
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
                        <h4>Add Session</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('session view') || Auth::user()->role->id == 1)<a href="{{ route('session.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('session.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3" for="start_year">Year<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-daterange" id="year">
                                            <input type="text" class="form-control" id="start" name="start_year" value="{{ old('start_year') }}">
                                        <div class="input-group-append"><div class="input-group-text">to</div></div>
                                            <input type="text" class="form-control" id="end" name="end_year" value="{{ old('end_year') }}">
                                        </div>
                                        @if ($errors->has('start_year'))
                                            <span class="text-danger">{{ $errors->first('start_year') }}</span>
                                        @endif
                                        @if ($errors->has('end_year'))
                                            <span class="text-danger">{{ $errors->first('end_year') }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label class="col-sm-3" for="name">Display Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Semester Name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label class="col-sm-3" for="details">Details</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="details" id="details" rows="5" placeholder="Enter Semester Details">{{ old('details') }}</textarea>
                                        @if ($errors->has('details'))
                                            <span class="text-danger">{{ $errors->first('details') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="create"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary w-100">Create</button>
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
<script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
@endpush

@push('page_scripts')
<script>

$(document).ready(function() {
    $('#start').datepicker({
        autoclose: true,
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    $('#start').datepicker('clearDates');

    $('#end').datepicker({
        autoclose: true,
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    $('#end').datepicker('clearDates');
});
</script>
@endpush

