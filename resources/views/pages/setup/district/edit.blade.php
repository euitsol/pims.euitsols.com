@extends('layouts.app')

@section('title', 'District Management')

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
                        <h4>Edit District</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('district.index') }}" class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('district.edit.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{ $district->id }}">
                                <div class="form-group row">
                                    <label class="col-sm-3" for="division_name">Select Division<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="division_name" name="division_name" required>
                                            <option value="" hidden>Select Division</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}" @if( $district->division->id == $division->id ) selected @endif>{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">District Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $district->name }}" placeholder="Enter District Name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="guard_name"></label>
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


@push('page_scripts')
<script>

</script>
@endpush

