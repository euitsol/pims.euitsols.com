@extends('layouts.app')

@section('title', 'Building Management')

@push('third_party_stylesheets')
<link href="{{ asset('assets/js/DataTable/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('page_css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Buildings</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add building') || Auth::user()->role->id == 1)<a href="{{ route('building.create') }}" class="btn btn-info">Add new building</a>@endif
                    </span>
                </div>
                <div class="card-body">

                    <div class="table table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Building Name</th>
                                    <th>Total Floor</th>
                                    <th>Total Room</th>
                                    <th>Total Seat</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buildings as $key => $building)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $building->name }}</td>
                                    <td>{{ count($building->floor) }}</td>
                                    <td>{{ $building->total_room() }}</td>
                                    <td>{{ $building->total_seat() }}</td>
                                    <td>{{ date('d-m-Y', strtotime($building->created_at)) }}</td>
                                    <td>{{ $building->created_user->name ?? 'system' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{route('building.show',[$building->id])}}" target="_blank" class="btn btn-info"
                                            data-id="{{ $building->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit building') || Auth::user()->role->id == 1)
                                                <a href="{{ route('building.edit', $building->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete building') || Auth::user()->role->id == 1)
                                                <a href="{{ route('building.destroy', $building->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                            @endif
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
        $('#table').DataTable({
            dom: 'Bfrtip'
            , buttons: [{
                    extend: 'pdfHtml5'
                    , title: 'Buildings'
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

    });
</script>
@endpush

