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
                            {{-- <a href="{{ route('teacher-assign.create') }}" class="btn btn-info">Assign Teacher</a> --}}
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
                                        <th>Group</th>
                                        <th>Shift</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($minfo as $value)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ $value->subjectAssign->session->start . '-' . $value->subjectAssign->session->end }}</td>
                                                    <td>{{ $value->subjectAssign->department->department_name }}</td>
                                                    <td>{{ $value->subjectAssign->semester->name }}</td>
                                                    <td>{{ $value->subjectAssign->subject->name }}</td>
                                                    <td>{{ $value->teacher_id }}</td>
                                                    <td>{{ $value->group->name }}</td>
                                                    <td>{{ $value->shift->name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                    <td>{{ $value->created_user->name ?? 'system' }}</td>
                                                    <td class="text-middle py-0 align-middle">
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                                                data-id="{{ $value->id }}"><i class="fas fa-eye"></i></a>
                                                            <a href="{{ route('subject-assign.edit', $value->id) }}"
                                                                class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                            <a href="{{ route('teacher-assign.destroy', $value->id) }}"
                                                                class="btn btn-danger btnDelete"><i
                                                                    class="fas fa-trash"></i></a>
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

    {{-- Modals --}}

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Details <span id="view-header"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-10 m-auto">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped">
                                <tbody id="view-tbody">
                                    <tr>
                                        <td>Division Name</td>
                                        <td>
                                            <span id="view-division"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>District Name</td>
                                        <td>
                                            <span id="view-name"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Created At</td>
                                        <td>
                                            <span id="view-createdAt"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Created By</td>
                                        <td>
                                            <span id="view-createdBy"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Updated At</td>
                                        <td>
                                            <span id="view-updatedAt"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Updated By</td>
                                        <td>
                                            <span id="view-updatedBy"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                        title: 'District Management',
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
            $('.btnView').click(function() {
                if ($(this).data('id') != null || $(this).data('id') != '') {
                    let url = ("{{ route('district.details', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function(response) {
                            console.log(response);

                            $('#view-name').html(response.name);
                            $('#view-division').html(response.division.name);
                            $('#view-createdAt').html(response.created_at ? new Date(response
                                .created_at) : '');
                            $('#view-createdBy').html(response.created_user ? response
                                .created_user.name : 'system');
                            $('#view-updatedAt').html(response.updated_at ? new Date(response
                                .updated_at) : '');
                            $('#view-updatedBy').html(response.updated_user ? response
                                .updated_user.name : '');

                            $('#view-modal').modal('show');
                        }
                    });
                } else {
                    alart('Something went wrong');
                }
            });

        });
    </script>
@endpush
