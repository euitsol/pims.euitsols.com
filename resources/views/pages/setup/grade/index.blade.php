@extends('layouts.app')

@section('title', 'Grade Calculation Management')

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
                            <h4>View Grade Calculation</h4>
                        </span>
                        <span class="float-right">
                            @if(Auth::user()->can('add grade-calculation') || Auth::user()->role->id == 1)<a href="{{ route('grade.create') }}" class="btn btn-info">Add new Grade Calculation</a>@endif
                        </span>
                    </div>
                    <div class="card-body">
                        @include('partial.flush-message')

                        <div class="table table-responsive">
                            <table id="table" class="">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Grade</th>
                                        <th>Mark Range</th>
                                        <th>Grade Point</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($db_data as $key => $d)

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $d->letterGrade->name }}</td>
                                            <td>{{ $d->mark_start.' - '. $d->mark_end }}</td>
                                            <td>{{number_format((float)$d->grade_point, 2, '.', '')}}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                                            <td>{{ $d->created_user->name ?? 'system' }}</td>
                                            <td class="text-middle py-0 align-middle">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="btn btn-info btnView"
                                                        data-id="{{ $d->id }}"><i class="fas fa-eye"></i></a>
                                                    @if (Auth::user()->can('edit grade-calculation') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('grade.edit', $d->id) }}"
                                                        class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                    @endif
                                                    @if (Auth::user()->can('delete grade-calculation') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('grade.destroy', $d->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
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
                                        <td>Grade</td>
                                        <td>
                                            <span id="view-grade"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mark Range</td>
                                        <td>
                                            <span id="view-mark-range"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Grade Point</td>
                                        <td>
                                            <span id="view-grade-point"></span>
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
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('grade.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'letterGrade', name: 'letterGrade'},
                    {data: 'marks', name: 'marks'},
                    {data: 'grade_point', name: 'grade_point'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'created_user', name: 'created_user'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        title: 'Grade Calculation Management',
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
            $('#table').on('click', 'tbody tr td .btn-group .btnView', function () {
                if ($(this).data('id') != null || $(this).data('id') != '') {
                    let url = ("{{ route('grade.show', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function(response) {
                            console.log(response);

                            $('#view-grade').html(response.letter_grade.name);
                            $('#view-mark-range').html(response.mark_start+'-'+response.mark_end);
                            $('#view-grade-point').html(response.grade_point);
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
