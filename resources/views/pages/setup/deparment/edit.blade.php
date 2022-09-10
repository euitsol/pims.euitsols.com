@extends('layouts.app')

@section('title', 'Department Management')

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
                        <h4>Edit {{$page_name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('user view') || Auth::user()->role->id == 1)<a href="{{ route('department.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('department.update',$data_update->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('put')
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Department Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $data_update->department_name }}" placeholder="Enter {{$page_name}} Name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="short_name">Short Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ $data_update->short_name }}" placeholder="Enter Department's Short Name" required>
                                        @if ($errors->has('short_name'))
                                            <span class="text-danger">{{ $errors->first('short_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="guard_name"></label>
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


