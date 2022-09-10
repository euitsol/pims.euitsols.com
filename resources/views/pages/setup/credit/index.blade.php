@extends('layouts.app')

@section('title', 'Credit Management')

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
                            <h4>View Shifts</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('credit.create') }}" class="btn btn-info">Add new Credit</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')

                        <div class="table table-responsive">
                            <table id="table" class="">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Credit Number</th>
                                        <th>Marks</th>
                                        <th>Class Hour</th>
                                        <th>Total Class</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($db_data as $key => $d)

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $d->credit_number }}</td>
                                            <td>{{ $d->marks }}</td>
                                            <td>{{ $d->class_hour }}</td>
                                            <td>{{ $d->total_class }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                                            <td>{{ $d->created_user->name ?? 'system' }}</td>
                                            <td class="text-middle py-0 align-middle">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="btn btn-info btnView"
                                                        data-id="{{ $d->id }}"><i class="fas fa-eye"></i></a>
                                                    {{-- @if (Auth::user()->can('user edit') || Auth::user()->role->id == 1) --}}
                                                    <a href="{{ route('credit.edit', $d->id) }}"
                                                        class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                    {{-- @endif --}}
                                                    {{-- @if (Auth::user()->can('user delete') || Auth::user()->role->id == 1) --}}
                                                    <a href="{{ route('credit.destroy', $d->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                                    {{-- @endif --}}
                                                </div>
                                                {{-- <div class="btn-group btn-group-sm">
                                                    <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('exam-name-admission.edit',$d->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('exam-name-admission.destroy',$d->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                </div> --}}
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
                                        <td>Credit Number</td>
                                        <td>
                                            <span id="view-number"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Marks</td>
                                        <td>
                                            <span id="view-marks"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Class Hour</td>
                                        <td>
                                            <span id="view-hour"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Class</td>
                                        <td>
                                            <span id="view-class"></span>
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
                        title: 'Credit Management',
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
            $('.btnView').click(function() {
                if ($(this).data('id') != null || $(this).data('id') != '') {
                    let url = ("{{ route('credit.show', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    console.log(_url);

                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function(response) {
                            console.log(response);

                            $('#view-number').html(response.credit_number);
                            $('#view-marks').html(response.marks);
                            $('#view-hour').html(response.class_hour);
                            $('#view-class').html(response.total_class);
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
