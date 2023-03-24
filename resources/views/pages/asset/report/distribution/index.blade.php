@extends('layouts.app')

@section('title', 'Distribution Products Report')

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
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Searched Info</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 info-div rounded m-auto">
                            <div class="custom-div m-auto">
                                <div>
                                    <span class="text-bold">Department :</span>
                                    @if (isset($department))
                                        <span>{{ $department }}</span>
                                    @else
                                        <span>All</span>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <span class="text-bold">section :</span>
                                    @if (isset($section))
                                        <span>{{ $section }}</span>
                                    @else
                                        <span>All</span>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <span class="text-bold">Subsection :</span>
                                    <span>
                                        @if (isset($subsection))
                                            {{ $subsection }}
                                        @endif
                                        All
                                    </span>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-md-12 mt-3">
                                    <span class="text-bold">Date Range:</span>
                                    @if (isset($str_date) || isset($end_date))
                                        @isset($str_date)
                                            <span>From :</span>
                                            <span>{{ $str_date }}</span>
                                        @endisset
                                        @isset($end_date)
                                            <span> To :</span>
                                            <span>{{ $end_date }}</span>
                                        @endisset
                                    @else
                                        <span> No date range</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <h4 class="text-center mb-4">Distribution Report</h4>
                @forelse($assign_products as $key => $departments)
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>{{$departments->first()->department->department_name}}</h4>
                        </span>

                        @if($key == 1)
                            <span class="float-right">
                                <a href="{{ route('asset.report.distribution.index') }}" class="btn btn-info">Back</a>
                            </span>
                        @endif
                    </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Section</th>
                                                    <th>Sub-section</th>
                                                    <th>Quantity</th>
                                                    <th>Category</th>
                                                    <th>Sub-category</th>
                                                    <th>Created At</th>
                                                    <th>created By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($departments as $department)
                                                @if (count($department->mainProduct))
                                                @foreach ($department->mainProduct as $p)

                                                    <tr>
                                                        <td>{{$p->product->name}}</td>
                                                        <td>{{$p->assignProduct->section->name}}</td>
                                                        <td>{{$p->assignProduct->subsection->name}}</td>
                                                        <td>{{Number_format($p->qty)}}</td>
                                                        <td>{{$p->product->category->name}}</td>
                                                        <td>{{$p->product->subcategory->name}}</td>
                                                        <td>{{date('d-m-Y',strtotime($p->created_at))}}</td>
                                                        <td>{{$p->created_user->name}}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a target="_blank" href="{{ route('asset.report.single_product.view', [$p->product->id]) }}"
                                                                    class="btn btn-info"><i
                                                                        class="fas fa-eye"></i></a>
                                                                {{-- @if(Auth::user()->can('edit report') || Auth::user()->role->id == 1)
                                                                    <a target="_blank" href="{{ route('asset.assign.product.edit', $p->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                                @endif
                                                                @if(Auth::user()->can('delete report') || Auth::user()->role->id == 1)
                                                                    <a href="{{ route('asset.assign.product.destroy', $p->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                                                @endif --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                @empty
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Distributio Report</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('asset.report.distribution.index') }}" class="btn btn-info">Back</a>
                        </span>

                    </div>
                    <div class="card-body p-5 text-center">
                        <h4>There are no distributed assets</h4>
                    </div>
                </div>
                @endforelse
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
                        title: 'Distribution report',
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
