@extends('layouts.app')

@section('title', 'Damage Report')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/js/DataTable/datatables.min.css') }}">
@endpush
@push('page_css')
    <style>
        .info-div {
            background-color: #faceb2;
            padding: 15px;
        }
        .custom-div {
            display: flex;
            justify-content: center;

        }

        
        table tr th,
        table tr td {
            vertical-align: middle !important;
        }

        @media screen and (max-width: 768px) {
            .custom-div {
                display: block;
            }

            .custom-div div {
                margin: 0px !important;
            }
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <h4 class="text-center mb-4">Damage Report</h4>
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Searched Info</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 info-div rounded m-auto">
                            <div class="custom-div m-auto">
                                {{-- @isset($department) --}}
                                <div>
                                    <span class="text-bold">Department :</span>
                                    @if (isset($department))
                                        <span>{{ $department }}</span>
                                    @else
                                        <span>All</span>
                                    @endif
                                </div>
                                {{-- @endisset --}}
                                {{-- @isset($section) --}}
                                <div class="ml-4">
                                    <span class="text-bold">section :</span>
                                    @if (isset($section))
                                        <span>{{ $section }}</span>
                                    @else
                                        <span>All</span>
                                    @endif
                                </div>
                                {{-- @endisset --}}
                                {{-- @isset($subsection) --}}
                                <div class="ml-4">
                                    <span class="text-bold">Subsection :</span>
                                    <span>
                                        @if (isset($subsection))
                                            {{ $subsection }}
                                        @endif
                                        All
                                    </span>
                                </div>
                                {{-- @endisset --}}
                            </div>

                            <div class="row text-center">
                                <div class="col-md-12 mt-3">
                                    <span class="text-bold">Date Range:</span>
                                    @if (isset($str_date) || isset($end_date))
                                        @isset($str_date)
                                            {{-- <div class="col-md-3"> --}}
                                            <span>From :</span>
                                            <span>{{ $str_date }}</span>
                                            {{-- </div> --}}
                                        @endisset
                                        @isset($end_date)
                                            {{-- <div class="col-md-3"> --}}
                                            <span> To :</span>
                                            <span>{{ $end_date }}</span>
                                            {{-- </div> --}}
                                        @endisset
                                    @else
                                        <span> No date range</span>
                                    @endif
                                </div>
                            </div>

                            {{-- <table class="table table-sm border border-1 table-striped table-info p-2 p-md-3">
                                <tbody>
                                    <tr>
                                        @isset($department)
                                            <th>Department</th>
                                            <td>{{ $department }}</td>
                                        @endisset
                                        @isset($section)
                                            <th>Section</th>
                                            <td>{{ $section }}</td>
                                        @endisset
                                        @isset($subsection)
                                            <th>Subsection</th>
                                            <td>{{ $subsection }}</td>
                                        @endisset
                                    </tr>

                                    <tr>
                                        @if (isset($str_date) || isset($end_date))

                                            <th>Date Range</th>
                                        @endif

                                        @isset($str_date)
                                            <td>from</td>
                                            <th>{{ $str_date }}</th>
                                        @endisset

                                        @isset($end_date)
                                            <td>to</td>
                                            <td>{{ $end_date }}</td>
                                            <td></td>
                                        @endisset
                                    </tr>
                                </tbody>
                            </table> --}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Total Info</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded p-3 table-info w-75 m-auto">
                            <table class="table table-bordered w-75 m-auto table-sm">
                                <tbody>
                                    {{-- <tr>
                                <td >Storage</td>
                                <td>:</td>
                                <td class="assign-qty"></td>
                            </tr> --}}
                                    <tr>
                                        <td>Assigned Quantity</td>
                                        <td>:</td>
                                        <td class="qty"></td>
                                    </tr>
                                    <tr>
                                        <td>Damage Quantity</td>
                                        <td>:</td>
                                        <td class="damage-qty"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    {{-- <div class="card-header">
                        <span class="float-left">
                            <h4>{{$product->first()->department->department_name}}</h4>
                        </span>

                        @if ($key == 1)
                            <span class="float-right">
                                <a href="{{ route('asset.report.Damage.index') }}" class="btn btn-info">Back</a>
                            </span>
                        @endif
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table data-table table-striped text-center ">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Storage</th>
                                        <th>Assigned Quantity</th>
                                        <th>Damage Quantity</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_damage_qty = 0;
                                        $qty = 0;
                                        $assigned_qty = 0;
                                    @endphp
                                    @forelse($damage_products as $key => $product)
                                        @php
                                            $total_damage_qty += $product->qty;
                                            $assigned_qty += $product->product->totalProduct();
                                            $qty += $product->product->qty;
                                        @endphp
                                        <tr>
                                            <td>{{ $product->product->name }}</td>
                                            <td>{{ Number_format($product->product->totalProduct()) }}</td>
                                            <td>{{ Number_format($product->product->qty) }}</td>
                                            <td>{{ Number_format($product->qty) }}</td>
                                            <td>{!! $product->des !!}</td>

                                            <td>{{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                                            <td>{{ $product->created_user->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a target="_blank"
                                                        href="{{ route('asset.report.single_product.view', [$product->product->id]) }}"
                                                        class="btn btn-info"><i class="fas fa-eye"></i></a>
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

@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {

            $('.assign-qty').text("{{ Number_format($assigned_qty) }}");
            $('.qty').text("{{ Number_format($qty) }}");
            $('.damage-qty').text("{{ Number_format($total_damage_qty) }}");

            $('.data-table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    title: 'Damage report',
                    download: 'open',
                    orientation: 'potrait',
                    pagesize: 'LETTER',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }, {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }, 'pageLength']
            });


        })
    </script>
@endpush
