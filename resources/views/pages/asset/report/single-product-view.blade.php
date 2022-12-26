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
                <div class="card">
                    <div class="card-header text-center">
                        <h4>{{$single_product->name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Total Quantity</th>
                                        <th>Total Price</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Updated By</th>
                                        <th>Updated At</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($single_product->moreProduct as $key => $product )
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td>{{$product->quantity}}</td>
                                        @php
                                            $total_p += $product->total_price;
                                            $qty += $product->quantity;
                                        @endphp
                                        <td>{{Number_format($product->total_price)}} tk</td>
                                        <td>{{$product->created_user->name}}</td>
                                        <td>{{date('d-m-Y',strtotime($product->created_at))}}</td>
                                        @if($product->updated_user)
                                            <td>{{ $product->updated_user->name }}</td>
                                            <td>{{date('d-m-Y',strtotime($product->updated_at))}}</td>
                                        @else
                                            <td></td>
                                            <td></td>
                                        @endif

                                        {{-- <td class="text-middle py-0 align-middle">
                                            <div class="btn-group">
                                                <a href="javascript:void(0)" class="btn btn-info btnView"
                                                    data-id="{{ $product->id }}"><i class="fas fa-eye"></i></a>
                                                @if (Auth::user()->can('edit blood-group') || Auth::user()->role->id == 1)
                                                <a href="{{ route('bloodgroup.edit', $product->id) }}"
                                                    class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                @endif
                                                @if (Auth::user()->can('delete blood-group') || Auth::user()->role->id == 1)
                                                <a href="{{ route('bloodgroup.destroy', $product->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
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
