@extends('layouts.app')

@section('title', 'User Management')

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
                            <h4>View Exams</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('exam-name-admission.create') }}" class="btn btn-info">Add new Exam</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')

                        <div class="table table-responsive">
                            <table id="table" class="">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($db_data as $key => $d)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->short_name }}</td>
                                            <td>{{ $d->created_at->diffForHumans() }}</td>
                                            <td class="text-middle py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('exam-name-admission.edit',$d->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('exam-name-admission.destroy',$d->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                        title: 'User Management',
                        download: 'open',
                        orientation: 'potrait',
                        pagesize: 'LETTER',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
@endpush
