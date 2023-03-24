@extends('layouts.app')

@section('title', 'User Management - Role')

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
                        <h4>Add Role</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('role view') || Auth::user()->role->id == 1)<a href="{{ route('users.role.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('users.role.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Display Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Role Display Name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label class="col-sm-3" for="guard_name">Guard Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="guard_name" name="guard_name" value="{{ old('guard_name') }}" placeholder="Enter Guard Name" required>
                                        @if ($errors->has('guard_name'))
                                            <span class="text-danger">{{ $errors->first('guard_name') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Permission<span class="text-danger">*</span></label>

                                    <div class="col-sm-9 row">
                                        @foreach($permissions as $permission)
                                            @foreach($permission as $value)
                                            <div class="col-sm-12">
                                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }} {{ $value->name }}</label><br>
                                            </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @if ($errors->has('permission'))
                                    <span class="text-danger">{{ $errors->first('permission') }}</span>
                                @endif
                                </div>
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
<script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush

@push('page_scripts')
<script>

</script>
@endpush

