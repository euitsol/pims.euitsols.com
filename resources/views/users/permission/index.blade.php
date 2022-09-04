@extends('layouts.app')

@section('title', 'User Management - Permission')

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
                        <h4>Permission</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('users.permission.add') }}" class="btn btn-info">Add Permission</a>
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                        <div class="table table-responsive">
                            <table id="table" class="">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Permission Name</th>
                                        <th>Prefix</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $key => $permission)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->prefix }}</td>
                                            <td>{{ date('d-m-Y', strtotime($permission->created_at)); }}</td>
                                            <td>{{ $permission->created_user->name ?? 'System' }}</td>
                                            <td></td>
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
                title: 'User Management - Permission',
                download: 'open',
                orientation: 'potrait',
                pagesize: 'LETTER',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            }, 'pageLength'
        ]
    } );
});
</script>
@endpush

