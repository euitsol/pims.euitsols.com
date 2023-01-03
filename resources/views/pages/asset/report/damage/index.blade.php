@extends('layouts.app')

@section('title', 'Damage Report')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/js/DataTable/datatables.min.css') }}">
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
                        <div class="col-md-8 m-auto">
                            <table class="table table-sm border border-1 table-striped table-info p-2 p-md-3">
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
                                        @if(isset($str_date) || isset($end_date))

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
                                <table class="table table-striped text-center ">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Damage Quantity</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th>created By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($damage_products as $key => $product)
                                        <tr>
                                            <td>{{ $product->product->name }}</td>
                                            <td>{{ $product->qty }}</td>
                                            <td>{{ $product->des }}</td>

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
            $('table').DataTable({
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
