@extends('layouts.app')

@section('title', 'Routine Management')

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
                        <h4>Search for routine</h4>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 m-auto">
                            <form action="{{ route('routine.search') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="session">Session<span class="text-danger">*</span></label>
                                <select name="session" id="session" class="form-control" required>
                                    <option value="" hidden>Select Session</option>
                                    @foreach ($sessions as $session )
                                        <option value="{{ $session->id }}" >{{ $session->start }} - {{ $session->end }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('session'))
                                    <span class="text-danger">{{ $errors->first('session') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="department">Department<span class="text-danger">*</span></label>
                                <select name="department" id="department" class="form-control" required>
                                    <option value="" hidden>Select Department</option>
                                    @foreach ($departments as $department )
                                        <option value="{{ $department->id }}" >{{ $department->department_name }} ( {{ $department->short_name }} )</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('department'))
                                    <span class="text-danger">{{ $errors->first('department') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="semester">Semester<span class="text-danger">*</span></label>
                                <select name="semester" id="semester" class="form-control" required>
                                    <option value="" hidden>Select Semester</option>
                                    @foreach ($semesters as $semester )
                                        <option value="{{ $semester->id }}" >{{ $semester->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('semester'))
                                    <span class="text-danger">{{ $errors->first('semester') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="group">Group<span class="text-danger">*</span></label>
                                <select name="group" id="group" class="form-control" required>
                                    <option value="" hidden>Select Group</option>
                                    @foreach ($groups as $group )
                                        <option value="{{ $group->id }}" >{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('group'))
                                    <span class="text-danger">{{ $errors->first('group') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="shift">Shift<span class="text-danger">*</span></label>
                                <select name="shift" id="shift" class="form-control" required>
                                    <option value="" hidden>Select shift</option>
                                    @foreach ($shifts as $shift )
                                        <option value="{{ $shift->id }}" >{{ $shift->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('shift'))
                                    <span class="text-danger">{{ $errors->first('shift') }}</span>
                                @endif
                            </div>
                            <div class="form-group mt-4">
                                <div class="text-center">
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

