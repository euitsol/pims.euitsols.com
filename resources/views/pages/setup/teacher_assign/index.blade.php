@extends('layouts.app')

@section('title', 'Teacher Assign Management')

@push('third_party_stylesheets')
    <link href="{{ asset('assets/js/DataTable/datatables.min.css') }}" rel="stylesheet">
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
                            <h4>Teacher Assign</h4>
                        </span>
                        <span class="float-right">
                        </span>
                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')

                        <div class="table table-responsive">
                            <table id="table" class="">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Sessions</th>
                                        <th>Departments</th>
                                        <th>Semesters</th>
                                        <th>Subjects</th>
                                        <th>Teacher</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($minfo as $value1)
                                        @php
                                            $data = $value1->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $data->subjectAssign->session->start . '-' . $data->subjectAssign->session->end }}
                                            </td>
                                            <td>{{ $data->subjectAssign->department->department_name }}</td>
                                            <td>{{ $data->subjectAssign->semester->name }}</td>
                                            <td>{{ $data->subjectAssign->subject->name }}</td>
                                            <td>
                                                @foreach ($value1 as $key => $value2)
                                                    @if ($key != 0)
                                                        <br>
                                                    @endif
                                                    <span>Teacher: {{ $value2->teacher->name }}</span> | <span>Group:
                                                        {{ $value2->group->name }} | </span><span>Shift:
                                                        {{ $value2->shift->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-middle py-0 align-middle">
                                                <div class="btn-group">
                                                    <a href="{{ route('teacher-assign.assign', $data->subjectAssign->id) }}"
                                                        class="btn btn-info" title="Assign Teacher"><i
                                                            class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        $(document).ready(function() {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        title: 'Teacher Management',
                        download: 'open',
                        orientation: 'potrait',
                        pagesize: 'LETTER',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
@endpush
