@extends('layouts.app')

@section('title', 'Asset Management - Edit Section')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Edit {{ $section->name }}</h4>
                        </span>
                        <span class="float-right">
                            @if (Auth::user()->can('section view') || Auth::user()->role->id == 1)
                                <a href="{{ route('asset.setup.section.index') }}" class="btn btn-info">Back</a>
                            @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <form action="{{ route('asset.setup.section.update') }}" method="POST"
                                    class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $section->id }}">

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="department_id">Department<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="department_id" id="department_id" class="form-control" required>
                                                <option value="hidden">Select Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        @if ($department->id == $section->department_id) selected @endif>
                                                        {{ $department->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="name">Section Name<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" id="name"
                                                placeholder="Enter section name" value="{{ $section->name }}" required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="short_name">Short Name<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="short_name" id="short_name"
                                            value="{{ $section->short_name }}" placeholder="Enter section short name"
                                                required>
                                            @if ($errors->has('short_name'))
                                                <span class="text-danger">{{ $errors->first('short_name') }}</span>
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
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $('select').select2();
    </script>
@endpush
