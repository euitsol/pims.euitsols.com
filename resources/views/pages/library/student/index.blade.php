@extends('layouts.app')

@section('title', 'Library Management - Register Members')
@push('third_party_stylesheets')
    <link href="{{ asset('assets/js/DataTable/datatables.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Library Registered Members </h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add library-student') || Auth::user()->role->id == 1)<a href="{{ route('library.member.create') }}" class="btn btn-info">Add new member</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <table  class="table table-striped text-center" id="table">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Date of Birth</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ( $students as $key=>$student)
                                   <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->phone}}</td>
                                    <td>{{date('d-m-Y',strtotime($student->dob))}}</td>
                                    <td>{{$student->created_user->name}}</td>
                                    <td>{{date('d-m-Y',strtotime($student->created_user->created_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                            data-id="{{ $student->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit library-student') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.member.edit', $student->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete library-student') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.member.destroy', $student->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                            @endif
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
                        <table class="table table-borderless table-striped" >
                            <tbody id="view-tbody">
                                <tr>
                                    <td>Name</td>
                                    <td>
                                        <span id="view-name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>
                                        <span id="view-phone"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>
                                        <span id="view-dob"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Present Address</td>
                                    <td>
                                        <span id="view-present_add"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Permanent Address</td>
                                    <td>
                                        <span id="view-permanent_add"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Emergency Contact(Name)</td>
                                    <td>
                                        <span id="view-ec_name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Emergency Contact(Phone)</td>
                                    <td>
                                        <span id="view-ec_phone"></span>
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
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#table').DataTable({
                dom: 'Bfrtip'
                , buttons: [{
                        extend: 'pdfHtml5'
                        , title: 'Students'
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
                    let url = ("{{ route('library.member.show', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function (response) {
                            $('#view-name').html(response.name);
                            $('#view-phone').html(response.phone);
                            $('#view-dob').html(response.dob);
                            $('#view-present_add').html(response.present_address);
                            $('#view-permanent_add').html(response.permanent_address);
                            $('#view-ec_name').html(response.ec_name);
                            $('#view-ec_phone').html(response.ec_phone);
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
