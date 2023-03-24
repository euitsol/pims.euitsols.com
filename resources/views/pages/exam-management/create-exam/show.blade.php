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
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Mark Distribution</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Subject</th>
                                                <th>Total Mark</th>
                                                @foreach ($exam_creates as $exams)
                                                    <th>{{ $exams->type->name }}</th>
                                                @endforeach
                                            </tr>
                                            @foreach ($subjects as $subject)
                                                <tr>
                                                    <td>{{ $subject->subject->name }}</td>
                                                    <td>{{ $subject->subject->credit->marks }}</td>
                                                    @foreach ($exam_creates as $exams)
                                                        <td>{{ calculate_sub_total_mark( $subject->subject->id, $exams->id ) }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
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
                                    <div class="table table-responsive">
                                        <table id="table" class="">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Exam Type</th>
                                                    <th>Total Mark</th>
                                                    <th>Duration</th>
                                                    <th>Fee</th>
                                                    <th>Created At</th>
                                                    <th>Created By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($exam_creates as $key => $ec)

                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $ec->type->name }}</td>
                                                        <td>{{ $ec->total_mark }}</td>
                                                        <td>
                                                            {{ $ec->duration }} {{ $ec->hour_minute_type() }}
                                                        </td>
                                                        <td>{{ $ec->total_fee }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($ec->created_at)) }}</td>
                                                        <td>{{ $ec->created_user->name ?? 'system' }}</td>
                                                        <td class="text-middle py-0 align-middle">
                                                            <div class="btn-group">
                                                                <a href="{{ route('em.create.view', $ec->id) }}" class="btn btn-info btnView"
                                                                    data-id="{{ $ec->id }}"><i class="fas fa-eye"></i></a>

                                                                <a href="{{ route('em.create.update', $ec->id) }}"
                                                                    class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>


                                                                <a href="{{ route('em.create.delete', $ec->id) }}" class="btn btn-danger btnDelete" onclick="alert('Are you sure about this action?')"><i class="fas fa-trash"></i></a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
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

