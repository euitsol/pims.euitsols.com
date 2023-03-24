@extends('layouts.app')

@section('title', 'Subject Management')

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
                        <h4>View subjects</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add subject') || Auth::user()->role->id == 1)<a href="{{ route('subject.create') }}" class="btn btn-info">Add new subject</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                    <div class="table table-responsive">
                        <table id="table" class="">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Department name</th>
                                    <th>Subject Name</th>
                                    <th>Subject Code</th>
                                    <th>Total Credit</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $key => $subject)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $subject->department->department_name }} ({{ $subject->department->short_name }})</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>{{ number_format((float)$subject->credit->credit_number, 2, '.', '') }}</td>
                                    <td>{{ date('d-m-Y', strtotime($subject->created_at)) }}</td>
                                    <td>{{ $subject->created_user->name ?? 'system' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-info btnView" data-id="{{ $subject->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit subject') || Auth::user()->role->id == 1)
                                                <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete subject') || Auth::user()->role->id == 1)
                                                <a href="{{ route('subject.destroy', $subject->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
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
                                    <td>Department Name</td>
                                    <td>
                                        <span id="view-department"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Subject Name</td>
                                    <td>
                                        <span id="view-subject"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Subject Code</td>
                                    <td>
                                        <span id="view-code"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Credit</td>
                                    <td>
                                        <span id="view-credit"></span>
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
            dom: 'Bfrtip'
            , buttons: [{
                    extend: 'pdfHtml5'
                    , title: 'Subjects'
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


        //view-modal
        $('.btnView').click( function(){
            if($(this).data('id') != null || $(this).data('id') != ''){
                let url = ("{{ route('subject.show', ['id']) }}");
                let _url = url.replace('id', $(this).data('id'));
                $.ajax({
                    url: _url,
                    method: "GET",
                    success: function (response) {
                        console.log(response);

                        $('#view-department').html(response.department.department_name+' ('+response.department.short_name+')');
                        $('#view-subject').html(response.name);
                        $('#view-code').html(response.code);
                        $('#view-credit').html(response.credit.credit_number);
                        $('#view-createdAt').html(response.created_at ? new Date(response.created_at) : '');
                        $('#view-createdBy').html(response.created_user ? response.created_user.name : 'system');
                        $('#view-updatedAt').html(response.updated_at ? new Date(response.updated_at) : '');
                        $('#view-updatedBy').html(response.updated_user ? response.updated_user.name: '');

                        $('#view-modal').modal('show');
                    }
                });
            }else{
                alart('Something went wrong');
            }
        });
    });
</script>
@endpush

