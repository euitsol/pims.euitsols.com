@extends('layouts.app')

@section('title', 'User Management - User')

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
                        <h4>Add Exam</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('exam-name-admission.index') }}" class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $err)
                                <li>
                                    {{$err}}
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    @endif
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('exam-name-admission.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Exam Name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Short Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name') }}" placeholder="Enter Short Name" required>
                                        @if ($errors->has('short_name'))
                                            <span class="text-danger">{{ $errors->first('short_name') }}</span>
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

@push('third_party_scripts')
<script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush

@push('page_scripts')
<script>

</script>
@endpush

