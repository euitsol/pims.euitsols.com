@extends('layouts.app')

@section('title', 'Subjects Assign Management')

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
                            <h4>Subjects Assign</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('subject-assign.create') }}" class="btn btn-info">Assign Subjects</a>
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
                                        <th>Total Credits</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($query as $value)

                                        @foreach ($value as $value2)
                                            @foreach ($value2 as $key => $value3)
                                                @php $data = $value3->first() @endphp

                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $data->session->start . '-' . $data->session->end }}</td>
                                                    <td>{{ $data->department->department_name }}</td>
                                                    <td>{{ $data->semester->name }}</td>
                                                    @php $count = 0; $total_credit = 0;  @endphp
                                                    <td>
                                                        @foreach ($value3 as $value4)
                                                            @if($count != 0) | @endif
                                                            {{ $value4->subject->name }}
                                                            @php
                                                                $count++;
                                                                $total_credit += $value4->subject->credit->credit_number;
                                                             @endphp
                                                        @endforeach
                                                    </td>
                                                    <td>

                                                            {{ number_format((float)$total_credit, 2, '.', ''); }}

                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                                    <td>{{ $data->created_user->name ?? 'system' }}</td>
                                                    <td class="text-middle py-0 align-middle">
                                                        <div class="btn-group">
                                                            <a href="{{ route('subject-assign.edit', $data->id) }}"
                                                                class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                            <a href="{{ route('subject-assign.destroy', $data->id) }}"
                                                                class="btn btn-danger btnDelete"><i
                                                                    class="fas fa-trash"></i>
                                                            </a>
                                                            <a href="{{ route('teacher-assign.create', $data->id) }}"
                                                                class="btn btn-info" title="Assign Teacher"><i class="fas fa-arrow-right"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
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
                        title: 'Subjects Assign Management',
                        download: 'open',
                        orientation: 'potrait',
                        pagesize: 'LETTER',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
@endpush
