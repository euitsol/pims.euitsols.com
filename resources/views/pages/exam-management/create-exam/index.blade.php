@extends('layouts.app')

@section('title', 'Exam Management')

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
                            <h4>Create Exam</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('em.create.search') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="session_id">Session</label>
                                        <select name="session_id" class="form-control select" id="session_id" required>
                                            <option value="" hidden>Select Session</option>
                                            @foreach ($session as $n)
                                                <option value="{{ $n->id }}"
                                                    @if (old('session_id') == $n->id) selected @endif>
                                                    {{ $n->start . '-' . $n->end }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('session_id'))
                                            <span class="text-danger">{{ $errors->first('session_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control select" id="department_id" required>
                                            <option value="" hidden>Select Department</option>
                                            @foreach ($department as $n)
                                                <option value="{{ $n->id }}"
                                                    @if (old('department_id') == $n->id) selected @endif>
                                                    {{ $n->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                            <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="semester_id">Semester</label>
                                        <select name="semester_id" class="form-control select" id="semester_id" required>
                                            <option value="" hidden>Select Semester</option>
                                            @foreach ($semester as $n)
                                                <option value="{{ $n->id }}"
                                                    @if (old('semester_id') == $n->id) selected @endif>{{ $n->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('semester_id'))
                                            <span class="text-danger">{{ $errors->first('semester_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4">Search</button>
                                </div>
                            </div>
                        </form>
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
        $(document).ready(function() {
            $('.select').select2();
        });
    </script>
@endpush
