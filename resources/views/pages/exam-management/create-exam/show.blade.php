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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Search filter</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shift_id">Shift</label>
                                                <select name="shift_id" class="form-control select" id="shift_id" required>
                                                    <option value="" hidden>Select Shift</option>
                                                    @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id }}" @if (old('shift_id')==$shift->id) selected @endif> {{ $shift->name}}</option>
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
                                                <select name="group_id" class="form-control select" id="group_id" required>
                                                    <option value="" hidden>Select Group</option>
                                                    @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}" @if (old('group_id')==$group->id) selected @endif>
                                                        {{ $group->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('group_id'))
                                                <span class="text-danger">{{ $errors->first('group_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-striped">
                                <tr>
                                    <td>Session</td>
                                    <td>:</td>
                                    <td>{{ $exam_search->session->start }} - {{ $exam_search->session->end }}</td>
                                </tr>
                                <tr>
                                    <td>Department</td>
                                    <td>:</td>
                                    <td>{{ $exam_search->department->department_name }}</td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>{{ $exam_search->semester->name }}</td>
                                </tr>
                                <tr>
                                    <td>Created By</td>
                                    <td>:</td>
                                    <td>{{ $exam_search->created_user->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List of Exams</h3>
                                    <div class="card-tools">
                                        <a href="{{ route('em.create.add', $exam_search->id) }}" class="btn btn-sm btn-info">Add Exam</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    The body of the card
                                </div>
                            </div>
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
        $(document).ready(function() {
            $('.select').select2();
        });
    </script>
@endpush

