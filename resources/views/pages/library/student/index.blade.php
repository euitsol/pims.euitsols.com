@extends('layouts.app')

@section('title', 'Library Management - Register')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Students</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add library-student') || Auth::user()->role->id == 1)<a href="{{ route('library.student.create') }}" class="btn btn-info">Add new student</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <table  class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse ( $students as $key=>$student)
                                   <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->created_user->name}}</td>
                                    <td>{{date('d-m-Y',strtotime($student->created_user->created_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                            data-id="{{ $student->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit library-student') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.student.edit', $student->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete library-student') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.student.destroy', $student->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                   </tr>
                                @empty
                                    <tr>
                                        <td colspan='5'><span>There are no categories</span></td>
                                    </tr>
                                @endforelse
                        </tbody>
                    </table>
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
                dom: 'Bfrtip'
                , buttons: [{
                        extend: 'pdfHtml5'
                        , title: 'Books'
                        , download: 'open'
                        , orientation: 'potrait'
                        , pagesize: 'LETTER'
                        , exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                    , {
                        extend: 'print'
                        , exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }, 'pageLength'
                ]
            });

        });
    </script>
@endpush
