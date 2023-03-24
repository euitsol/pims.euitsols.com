@extends('layouts.app')

@section('title', 'Exam Shifts')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add Exam Shift</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('examshifts.index') }}" class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('examshifts.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Exam Shift Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Exam Shift Name" required>

                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="start">Start Time<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="time" onfocus="this.showPicker()" class="form-control" id="start" name="start" value="{{ old('start') }}" placeholder="Enter Exam Start Time" required>
                                        <small>End time will be calculated automatically</small>
                                        @if ($errors->has('start'))
                                            <span class="text-danger">{{ $errors->first('start') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3"></label>
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

