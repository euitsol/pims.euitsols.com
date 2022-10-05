@extends('layouts.app')

@section('title', 'View students according to semester')

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
                        <h4>View students from {{$minfo->name}}</h4>
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                    <div class="table table-responsive">
                        <table id="table" class="">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Department</th>
                                    <th>Semester</th>
                                    <th>Student Name</th>
                                    <th>Student Phone</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($minfo->admittedStdAssign  as $key=> $value1)

                                    <tr>
                                       <td>{{ $key + 1 }}</td>
                                       <td>{{ $value1->studentInfo->department->department_name}}</td>
                                       <td>{{ $minfo->name }}</td>
                                       <td>{{ $value1->studentInfo->name }}</td>
                                       <td>{{ $value1->studentInfo->phone }}</td>
                                       <td>{{ date('d-m-Y', strtotime($value1->studentInfo->created_at)); }}</td>
                                       <td>
                                           <div class="btn-group">

                                               {{-- //view  --}}
                                               <a href="{{route('student.show',$value1->studentInfo->id)}}" class="btn btn-info btnView"><i class="fas fa-eye"></i></a>

                                               {{-- //edit  --}}
                                               <a href="{{ route('student.student-admit.edit', $value1->studentInfo->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>

                                               {{-- //delete  --}}
                                               <a href="{{ route('student.admitted.destroy', $value1->studentInfo->id) }}" class="btn btn-danger btnDelete" title="Delete"><i class="fas fa-trash"></i></a>

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
