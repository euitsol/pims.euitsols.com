@extends('layouts.app')

@section('title', 'Asset Management - Department Wise Product Show')

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
@php
    $first_product = $department_products->first();
    $qty = 0;
    $total_p = 0;
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">

                <div class="card">
                    <div class="card-header text-center">
                        <h4>{{ $first_product->department_id ? $first_product->department->department_name : 'Common Assets' }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Product Name</th>
                                        <th>Total Quantity</th>
                                        <th>Available Quantity</th>
                                        <th>Total Price</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Updated By</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($department_products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ Number_format($product->totalProduct()) }}</td>
                                            <td>{{ Number_format($product->qty) }}</td>
                                            <td>BDT {{ Number_format($product->totalPrice()) }}</td>
                                            <td>{{ $product->created_user->name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($product->updated_at)) }}</td>
                                            @if ($product->updated_user)
                                                <td>{{ $product->updated_user->name }}</td>
                                                <td>{{ date('d-m-Y', strtotime($product->updated_at)) }}</td>
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('asset.report.single_product.view', [$product->id]) }}"
                                                        class="btn btn-info" data-id="{{ $product->id }}"><i
                                                            class="fas fa-eye"></i></a>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th></th>
                                        <th class="border-top-2">Total</th>
                                        <th class="border-top-2"> = {{$qty}}</th>
                                        <th class="border-top-2">  =BDT {{Number_format($total_p)}} </th>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
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
                    title: 'Department Wise Products',
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
        });
    </script>
@endpush
