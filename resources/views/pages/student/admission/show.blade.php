@extends('layouts.app')

@section('title', 'Pending students')

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
                        <h4>View {{$page_name}}</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('student.student-admit.create') }}" class="btn btn-info">Admit new Student</a>
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                    <div class="table table-responsive">
                        <table id="table" class="">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Department Name</th>
                                    <th>Student Name</th>
                                    <th>Student Phone</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->department->department_name ?? ''}}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->created_at)); }}</td>
                                        <td>
                                            <div class="btn-group">

                                                {{-- //view  --}}
                                                <a href="{{route('student.student-admit.show',$value->id)}}" class="btn btn-info btnView" data-id="{{ $value->id }}"><i class="fas fa-eye"></i></a>

                                                {{-- //edit  --}}
                                                <a href="{{ route('student.student-admit.edit', $value->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>

                                                {{-- //delete  --}}
                                                <a href="{{ route('student.admitted.destroy', $value->id) }}" class="btn btn-danger btnDelete" title="Delete"><i class="fas fa-trash"></i></a>

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
    $('#table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                title: 'User Management',
                download: 'open',
                orientation: 'potrait',
                pagesize: 'LETTER',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            }, 'pageLength'
        ]
    });

});
</script>
@endpush
