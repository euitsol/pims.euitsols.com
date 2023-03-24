@extends('layouts.app')

@section('title', 'Asset Management - Add Sub-section')

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
                            <h4>Add new sub-section</h4>
                        </span>
                        <span class="float-right">
                            @if (Auth::user()->can('sub-section view') || Auth::user()->role->id == 1)
                                <a href="{{ route('asset.setup.subsection.index') }}" class="btn btn-info">Back</a>
                            @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <form action="{{ route('asset.setup.subsection.store') }}" method="POST"
                                    class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-3" for="department_id">Section<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="section_id" id="section_id" class="form-control" required>
                                                <option value="">Select Section</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}">{{ $section->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3" for="name">Sub-section Name<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" id="name"
                                                value="{{ old('name') }}" placeholder="Enter sub-section name" required>
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
                                                value="{{ old('short_name') }}" placeholder="Enter sub-section short name" required>
                                            @if ($errors->has('short_name'))
                                                <span class="text-danger">{{ $errors->first('short_name') }}</span>
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
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $('select').select2();
    </script>
@endpush
