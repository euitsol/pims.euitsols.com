@extends('layouts.app')

@section('title', 'Subject Management')

@push('third_party_stylesheets')

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
                        <h4>Edit subject</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('subject view') || Auth::user()->role->id == 1)<a href="{{ route('subject.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('subject.update') }}" method="POST" class="form-horizontal">
                            @csrf
                                <input type="hidden" name="id" value="{{ $subject->id }}">
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Subject Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" value="{{ $subject->name }}" placeholder="Enter subject name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="code">Subject Code<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="code" id="code" value="{{ $subject->code }}" placeholder="Enter subject code" required>
                                        @if ($errors->has('code'))
                                            <span class="text-danger">{{ $errors->first('code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="department">Department<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 row">
                                        <div class="col-md-11">
                                            <select class="form-control" id="department" name="department_name" required>
                                                <option value="" hidden>Select department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" @if( $subject->department_id == $department->id) selected @endif>{{ $department->department_name }} ({{ $department->short_name }})</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('department_name'))
                                                <span class="text-danger">{{ $errors->first('department_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-1 rounded-0">
                                            @if(Auth::user()->can('department add') || Auth::user()->role->id == 1)<a href="{{ route('department.create') }}" target="_blank" class="btn btn-info" title="Add new department"><i class="fas fa-plus-square"></i></a>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="credit">Credit<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 row">
                                        <div class="col-md-11">
                                            <select class="form-control" id="credit" name="credit_number" required>
                                                <option value="" hidden >Select credit</option>
                                                @foreach($credits as $credit)
                                                    <option value="{{ $credit->id }}" @if( $subject->credit_id == $credit->id) selected @endif>{{ number_format((float)$credit->credit_number, 2, '.', '') }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('credit_number'))
                                                <span class="text-danger">{{ $errors->first('credit_number') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-1 rounded-0">
                                            @if(Auth::user()->can('credit add') || Auth::user()->role->id == 1)<a href="{{ route('credit.create') }}" target="_blank" class="btn btn-info" title="Add new credit"><i class="fas fa-plus-square"></i></a>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3"></label>
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

@endpush

@push('page_scripts')
<script>

</script>
@endpush

