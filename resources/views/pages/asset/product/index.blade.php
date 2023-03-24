@extends('layouts.app')

@section('title', 'Asset Management - Asset')
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
                        <h4>Asset</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add asset-category') || Auth::user()->role->id == 1)<a href="{{ route('asset.product.create') }}" class="btn btn-info">Add new product</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center" id="table">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Asset Name</th>
                                <th>Quantity</th>
                                <th>Available Quantity</th>
                                <th>Unit </th>
                                <th>Total Price </th>
                                <th>Brand </th>
                                <th>Category </th>
                                <th>Department</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ( $products as $key=>$product)
                                   <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{Number_format($product->totalProduct())}}</td>
                                    <td>{{Number_format($product->qty)}}</td>
                                    <td>{{$product->unit->name}}</td>
                                    <td>BDT {{ number_format($product->total_price,2) }} </td>
                                    <td>{{$product->brand->name}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->department->department_name ?? 'Common Asset'}}</td>
                                    <td>{{$product->created_user->name}}</td>
                                    <td>{{date('d-m-Y',strtotime($product->created_user->created_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                            data-id="{{ $product->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit product') || Auth::user()->role->id == 1)
                                                <a href="{{ route('asset.product.edit', $product->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete product') || Auth::user()->role->id == 1)
                                                <a href="{{ route('asset.product.destroy', $product->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                            @endif
                                            <a href="{{ route('asset.product.add.more', $product->id) }}" class="btn btn-info"
                                            data-id="{{ $product->id }}"><i class="fas fa-plus"></i></a>
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
                                    <td>Image</td>
                                    <td>
                                        <span id="view-img"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Asset Name</td>
                                    <td>
                                        <span id="view-product-name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quantity</td>
                                    <td>
                                        <span id="view-qty"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Per unit Price</td>
                                    <td>
                                        <span id="view-per-unit-price"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Price</td>
                                    <td>
                                        <span id="view-total-price"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Asset Description</td>
                                    <td>
                                        <span id="view-product-des"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Warranty</td>
                                    <td>
                                        <span id="view-warranty"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unit</td>
                                    <td>
                                        <span id="view-unit"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td>
                                        <span id="view-brand"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Category Name</td>
                                    <td>
                                        <span id="view-cat-name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Department Name</td>
                                    <td>
                                        <span id="view-department-name"></span>
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
                    , title: 'Assets'
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
                    let url = ("{{ route('asset.product.show', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function (response) {
                            $('#view-img').html(response.img);
                            $('#view-product-name').html(response.name);
                            $('#view-qty').html(response.qty);
                            $('#view-per-unit-price').html(response.total_price/response.qty);
                            $('#view-total-price').html(response.total_price);
                            $('#view-product-des').html(response.description);
                            $('#view-warranty').html(response.warranty+' years');
                            $('#view-unit').html(response.unit.name);
                            $('#view-brand').html(response.brand.name);
                            $('#view-cat-name').html(response.category.name);
                            $('#view-subcat-name').html(response.subcategory.name);
                            $('#view-department-name').html(response.department ? response.department.department_name : 'Common Asset');
                            $('#view-status').html(response.status);
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
