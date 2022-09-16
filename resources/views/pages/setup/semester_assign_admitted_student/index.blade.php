@extends('layouts.app')

@section('title', 'Admit Student Mangement')

@push('third_party_stylesheets')
@endpush

@push('page_css')
    <style>
        .row span {
            font-size: 18px;
            /* margin: 10px,0px,10px,0px; */
        }

    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h1 class="card-title">Semester Assign for Admitted Student</h1>
                        </span>
                        {{-- <span class="float-right">
                            <a href="{{ route('board.create') }}" class="btn btn-info">Add new Board</a>
                        </span> --}}
                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Student's Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <span>Student's Name</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->name }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Department's Name</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->departments_id }}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <span>Father's Name</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->father_name }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Mother's Name</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->mother_name }}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <span>Present Adddress</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->present_address }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Permanent Address</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->parmanent_address }}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <span>E-mail</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->email }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Phone</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>: {{ $db_data->phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- //Student Assign --}}
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Assign Student</h3>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="student_id">Student ID</label>
                                                <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}" placeholder="Enter Student ID" required>
                                                @if ($errors->has('student_id'))
                                                    <span class="text-danger">{{ $errors->first('student_id') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="semester_id">Semester</label>
                                                <select name="semester_id" class="form-control" id="semester_id"
                                                    style="width: 100%;">
                                                    <option value="" hidden>Select Semester</option>
                                                    @foreach ($semester as $n)
                                                        <option value="{{ $n->id }}" @if(old('semester_id') ==$n->id) selected @endif >{{ $n->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('semester_id'))
                                                    <span class="text-danger">{{ $errors->first('semester_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="session_id">Session</label>
                                                <select name="session_id" class="form-control"
                                                    style="width: 100%;">
                                                    <option value="" hidden>Select Session</option>
                                                    @foreach ($session as $n)
                                                        <option value="{{ $n->id }}" @if(old('session_id') ==$n->id) selected @endif>{{ $n->start.'-'.$n->end }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('session_id'))
                                                    <span class="text-danger">{{ $errors->first('session_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shift_id">Shift</label>
                                                <select name="shift_id" id="shift_id" class="form-control"
                                                    style="width: 100%;">
                                                    <option value="" hidden>Select Shift</option>
                                                    @foreach ($shift as $n)
                                                        <option value="{{ $n->id }}" @if(old('shift_id') ==$n->id) selected @endif>{{ $n->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('shift_id'))
                                                    <span class="text-danger">{{ $errors->first('shift_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="group_id">Group</label>
                                                <select name="group_id" id="group_id" class="form-control"
                                                    style="width: 100%;" >
                                                    <option value="" hidden>Select Group</option>
                                                    @foreach ($group as $n)
                                                        <option value="{{ $n->id }}" @if(old('group_id') ==$n->id) selected @endif>{{ $n->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('group_id'))
                                                    <span class="text-danger">{{ $errors->first('group_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3" for="guard_name"></label>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Assign</button>
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
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
@endpush
