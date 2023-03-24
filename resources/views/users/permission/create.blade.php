@extends('layouts.app')

@section('title', 'User Management - Permission')

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
                        <h4>Add Permission</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('users.permission.index') }}" class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('users.permission.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Display Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Permission Display Name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="prefix">Permission Prefix<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="prefix" name="prefix" value="{{ old('prefix') }}" placeholder="Enter Premission Prefix to Group" required>
                                        @if ($errors->has('prefix'))
                                            <span class="text-danger">{{ $errors->first('prefix') }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label class="col-sm-3" for="guard_name">Guard Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="guard_name" name="guard_name" value="{{ old('guard_name') }}" placeholder="Enter Permission Guard Name" required>
                                        @if ($errors->has('guard_name'))
                                            <span class="text-danger">{{ $errors->first('guard_name') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label class="col-sm-3" for="guard_name"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
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

