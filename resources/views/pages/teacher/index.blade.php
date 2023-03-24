@extends('layouts.app')

@section('title', 'Teacher Management')

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
                            <h4>View Teachers</h4>
                        </span>
                        <span class="float-right">
                            @if(Auth::user()->can('add teacher') || Auth::user()->role->id == 1)<a href="{{ route('teacher.create') }}" class="btn btn-info">Add new Teacher</a>@endif
                        </span>
                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')

                        <div class="table table-responsive">
                            <table id="table" class="">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Teacher Name</th>
                                        <th>Department</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($db_data as $key => $d)

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->department->department_name  }}</td>
                                            <td>{{ $d->phone }}</td>
                                            <td>{{ $d->email }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                                            <td>{{ $d->created_user->name ?? 'system' }}</td>
                                            <td class="text-middle py-0 align-middle">
                                                <div class="btn-group">

                                                    @if (Auth::user()->can('show teacher') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('teacher.info', $d->id) }}" class="btn btn-info btnView"><i class="fas fa-eye"></i></a>
                                                    @endif

                                                    @if (Auth::user()->can('edit teacher') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('teacher.edit', $d->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                    @endif

                                                    @if (Auth::user()->can('delete teacher') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('teacher.destroy', $d->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                                    @endif

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
                                        <td>Nationality</td>
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
                        title: 'Nationality Management',
                        download: 'open',
                        orientation: 'potrait',
                        pagesize: 'LETTER',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    }, 'pageLength'
                ]
            });
            // $('.btnView').click(function() {
            //     if ($(this).data('id') != null || $(this).data('id') != '') {
            //         let url = ("{{ route('nationality.show', ['id']) }}");
            //         let _url = url.replace('id', $(this).data('id'));
            //         $.ajax({
            //             url: _url,
            //             method: "GET",
            //             success: function(response) {
            //                 console.log(response);

            //                 $('#view-name').html(response.name);
            //                 // $('#view-short-name').html(response.short_name);
            //                 $('#view-createdAt').html(response.created_at ? new Date(response
            //                     .created_at) : '');
            //                 $('#view-createdBy').html(response.created_user ? response
            //                     .created_user.name : 'system');
            //                 $('#view-updatedAt').html(response.updated_at ? new Date(response
            //                     .updated_at) : '');
            //                 $('#view-updatedBy').html(response.updated_user ? response
            //                     .updated_user.name : '');

            //                 $('#view-modal').modal('show');
            //             }
            //         });
            //     } else {
            //         alart('Something went wrong');
            //     }
            // });

        });
    </script>
@endpush
