@extends('layouts.app')

@section('title', 'Asset Management - Supplier')
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
                        <h4>Supplier</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add asset-supplier') || Auth::user()->role->id == 1)<a href="{{ route('asset.setup.supplier.create') }}" class="btn btn-info">Add new supplier</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center" id="table">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Shop Name</th>
                                <th>Owner Name</th>
                                <th>Phone</th>
                                <th>E-mail</th>
                                <th>Adress</th>
                                <th>Details</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ( $suppliers as $key=>$supplier)
                                   <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$supplier->shop_name}}</td>
                                    <td>{{$supplier->owner_name}}</td>
                                    <td>{{$supplier->phone}}</td>
                                    <td>{{$supplier->email}}</td>
                                    <td>{!! $supplier->address !!}</td>
                                    <td>{!! $supplier->details ?? '' !!}</td>
                                    <td>{{$supplier->created_user->name}}</td>
                                    <td>{{date('d-m-Y',strtotime($supplier->created_user->created_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                            data-id="{{ $supplier->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit supplier') || Auth::user()->role->id == 1)
                                                <a href="{{ route('asset.setup.supplier.edit', $supplier->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete supplier') || Auth::user()->role->id == 1)
                                                <a href="{{ route('asset.setup.supplier.destroy', $supplier->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
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
                        <table class="table table-borderless table-striped">
                            <tbody id="view-tbody">
                                <tr>
                                    <td>Shop Name</td>
                                    <td>
                                        <span id="view-shop_name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Owner Name</td>
                                    <td>
                                        <span id="view-owner_name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>
                                        <span id="view-phone"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>
                                        <span id="view-address"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Details</td>
                                    <td>
                                        <span id="view-details"></span>
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
                    , title: 'Suppliers'
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
                    let url = ("{{ route('asset.setup.supplier.show', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function (response) {
                            $('#view-shop_name').html(response.shop_name);
                            $('#view-owner_name').html(response.owner_name);
                            $('#view-phone').html(response.phone);
                            $('#view-address').html(response.address);
                            $('#view-details').html(response.details);
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
