@extends('layouts.app')

@section('title', 'Asset Management -Single Product Show')

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
        .bg-warning{
            background-color: #f1f1f1 !important;
        }
    </style>
@endpush
@php
    $qty = 0;
    $total_p = 0;
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <h1 class="text-center">{{$single_product->name}}</h1>
                <div class="card">
                    <div class="card-header">
                        <h4>Stored Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                               <div class="card bg-warning">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-sm table-info m-auto">
                                            <tbody>
                                                <tr>
                                                    <th>Department Name</th>
                                                    <td>{{$single_product->departmentName()}}</td>
                                                    <th>Sub-category Name</th>
                                                    <td>{{$single_product->subcategory->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <td>{{$single_product->name}}</td>
                                                    <th>Quantity</th>
                                                    <td>{{$single_product->totalProduct()}}</td>
                                                </tr>
                                                <tr>

                                                    <th>Total Price</th>
                                                    <td>{{Number_format($single_product->totalPrice())}}৳</td>
                                                    <th>Available Quantity</th>
                                                    <td>{{$single_product->qty}}</td>

                                                    {{-- <th>Supplier </th>
                                                    <td>
                                                        @foreach ($single_product->supplier as $supplier)
                                                            {{$supplier->id!=0 ? ' | ' : ''.$supplier->name}}
                                                        @endforeach
                                                    </td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                               </div>
                            </div>

                            <div class="col-md-7 m-auto ">
                                <div class="card bg-warning" >
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-info">
                                                <h5>Multipule Time Assigned</h5>
                                                <thead>
                                                    <tr>
                                                        <th>Quantity</th>
                                                        <th>Warranty</th>
                                                        <th>total Price</th>
                                                        <th>Supplier </th>
                                                        <th>Created At </th>
                                                        <th>Created By </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($single_product->moreProduct as $product )
                                                        <tr>
                                                            <td>{{$product->quantity}}</td>
                                                            <td>{{$product->warranty}}</td>
                                                            <td>{{Number_format($product->total_price)}} <span class="taka">৳</h4></td>
                                                            <td>{{$product->supplier->shop_name}}</td>
                                                            <td>{{date('d-m-Y',strtotime($product->created_at))}}</td>
                                                            <td>{{$product->created_user->name}}</td>
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
                </div>
                @if(count($assigned_products))
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Assigned Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Department Name</th>
                                        <th>Section Name</th>
                                        <th>Sub-section Name</th>
                                        <th>Quantity</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assigned_products as $key => $assigned_product )
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td>{{$assigned_product->assignProduct->departmentName()}}</td>
                                        <td>{{$assigned_product->assignProduct->section->name}}</td>
                                        <td>{{$assigned_product->assignProduct->subsection->name}}</td>
                                        <td>{{$assigned_product->qty}}</td>
                                        {{-- @php
                                            $total_p += $assigned_product->total_price;
                                            $qty += $assigned_product->quantity;
                                        @endphp --}}
                                        <td>{{$assigned_product->created_user->name}}</td>
                                        <td>{{date('d-m-Y',strtotime($assigned_product->created_at))}}</td>
                                        {{-- @if($assigned_product->updated_user)
                                            <td>{{ $assigned_product->updated_user->name }}</td>
                                            <td>{{date('d-m-Y',strtotime($assigned_product->updated_at))}}</td>
                                        @else
                                            <td></td>
                                            <td></td>
                                        @endif --}}
                                        {{-- <td class="text-middle py-0 align-middle">
                                            <div class="btn-group">
                                                <a href="javascript:void(0)" class="btn btn-info btnView"
                                                    data-id="{{ $assigned_product->id }}"><i class="fas fa-eye"></i></a>
                                                @if (Auth::user()->can('edit blood-group') || Auth::user()->role->id == 1)
                                                <a href="{{ route('bloodgroup.edit', $assigned_product->id) }}"
                                                    class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                @endif
                                                @if (Auth::user()->can('delete blood-group') || Auth::user()->role->id == 1)
                                                <a href="{{ route('bloodgroup.destroy', $assigned_product->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                                @endif
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th></th>
                                        <th class="border-top-2">Total</th>
                                        <th class="border-top-2"> = {{$qty}}</th>
                                        <th class="border-top-2">  = {{Number_format($total_p)}} tk</th>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                </div>
                @endif

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
                    title: 'Products',
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
