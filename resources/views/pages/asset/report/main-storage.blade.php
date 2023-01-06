@extends('layouts.app')

@section('title', 'Asset Management - Main Storage Report')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/js/DataTable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('page_css')
    <style>
        .nav-tabs li {
            border-radius: 10px !important;
        }

        .nav-tabs li .nav-link {
            background: #0c9fce !important;
            color: white;
            border-radius: 7px 7px 0px 0px;

        }

        .nav-tabs li .active {
            background: white !important;
        }

        caption {
            padding-top: 0rem !important;
            caption-side: top !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Search</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('asset.report.main_storage.filter') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-1 offset-md-2">
                                    <label for="date">Date range<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6 text-left ">
                                    <div class="input-group">
                                        <input name="str_date" type="date" id="str_date" class="form-control date"
                                            value="{{$str_date?? ''}}">
                                        <span class="input-group-text">to</span>
                                        <input name="end_date" type="date" id="end_date" class="form-control date"
                                            value="{{$end_date ?? ''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 offset-md-2">
                                    <label for="user">Department</label>
                                </div>
                                <div class="col-md-6 text-left mt-2">

                                    <select name="department_id" id="department_id" class="form-control">
                                        <option value="">All</option>
                                        <option value="common_asset"  @if (isset($department_id)) @if ($department_id == 'common_asset') selected @endif @endif >Common Asset</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" @if (isset($department_id)) @if ($department_id == $department->id) selected @endif @endif >
                                                {{ $department->department_name }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-md-3 text-center m-auto">
                                    <button class="btn btn-info w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card" id="book_info">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Main Sotrage Report</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Product Name</th>
                                        <th>Total Quantity</th>
                                        <th>Total Price</th>
                                        <th>Available Quantity</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($all_products)
                                        @foreach ($all_products as $products)
                                            @php
                                               $product = $products->first();
                                               $total_qty = 0;
                                               $total_p = 0;
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $product->department ? $product->department->department_name : 'Common Asset' }}
                                                </td>
                                                <td>
                                                    @foreach ($products as $key => $p)
                                                        {{$key==0 ? '' : '|'}} {{$p->name}}
                                                        @php
                                                            $total_qty += $p->qty;
                                                            $total_p += $p->total_price;
                                                        @endphp
                                                    @endforeach
                                                </td>
                                                <td>{{ Number_format($product->departTotalProduct()) }}</td>
                                                <td>BDT {{ Number_format($product->totalPrice() )}}</td>
                                                <td>{{ Number_format($product->departAvailableProduct()) }}</td>
                                                <td>{{$product->created_user->name}}</td>
                                                <td>{{date('d-m-Y',strtotime($product->created_at))}}</td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{route('asset.report.department_product.view',[$product->department_id ?? 'common_asset'])}}" class="btn btn-info" data-id="{{ $product->department_id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    @isset($department_wise)
                                    @foreach ($department_wise as $product)
                                    <tr>
                                        <td>{{ $product->department ? $product->department->department_name : 'Common Asset' }}
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ Number_format($product->qty) }}</td>
                                        <td>BDT {{ Number_format($product->total_price) }}</td>
                                        <td>{{$product->created_user->name}}</td>
                                        <td>{{date('d-m-Y',strtotime($product->created_at))}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{route('asset.report.single_product.view',[$product->id])}}" class="btn btn-info"
                                                    data-id="{{ $product->id }}"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                    @endisset
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
                                        <td>Student's Name</td>
                                        <td>
                                            <span id="view-std-name"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Student's Phone</td>
                                        <td>
                                            <span id="view-std-phone"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Book's Name</td>
                                        <td>
                                            <span id="view-name"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>
                                            <span id="view-cat"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Department's Name</td>
                                        <td>
                                            <span id="view-department"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Bookshelf</td>
                                        <td>
                                            <span id="view-bookshelf"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Quantity</td>
                                        <td>
                                            <span id="view-qty"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Assign date</td>
                                        <td>
                                            <span id="view-assign-date"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Return date</td>
                                        <td>
                                            <span id="view-return-date"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Returned date</td>
                                        <td>
                                            <span id="view-returned-date"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <span id="view-status"></span>
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
    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('select').select2();
            $('table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    title: 'Main Storage',
                    download: 'open',
                    orientation: 'potrait',
                    pagesize: 'LETTER',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }, {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }, 'pageLength']
            });;

            //view-modal
            $('.btnView').click(function() {
                if ($(this).data('id') != null || $(this).data('id') != '') {
                    let url = ("");
                    let _url = url.replace('id', $(this).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function(response) {
                            console.log(response)
                            $('#view-std-name').html(response.student.name);
                            $('#view-std-phone').html(response.student.phone);
                            $('#view-name').html(response.book.name);
                            $('#view-cat').html(response.book.category.name);
                            $('#view-department').html(response.book.category.department
                                .department_name);
                            $('#view-bookshelf').html(response.book.bookshelf.name);
                            $('#view-qty').html( Number((response.qty).toFixed(1)).toLocaleString());
                            $('#view-assign-date').html(response.assign_date);
                            $('#view-return-date').html(response.return_date);
                            $('#view-returned-date').html(response.returned_date ?? '');
                            $('#view-status').html(response.status);
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
