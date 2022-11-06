@extends('layouts.app')

@section('title', 'Building Management')

@push('third_party_stylesheets')

@endpush

@push('page_css')
<style>
    .registration-title h2 {
        background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 2%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 90%);
    }

    .student-photo{
        height: 125px;
        width: 100%;
        object-fit: contain;
    }
    .clr table tr th {
        background: #ECECEC !important;
    }
    .bg-secondary {
    background-color: #0ba5ef45 !important;
    color: black !important;
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

                            <h4>Building Details</h4>

                    </span>
                    <span class="float-right">
                        <button type="button" onclick="printT('building_details')" class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Building Print </button>
                    </span>
                </div>
                <div class="card-body" id="building_details">
                    <h4 class="w-100 text-center text-capitalize text-info">{{$building->name}}</h4>
                    <div class="row mb-5">
                        <div class="col-md-4 m-auto">
                            <table class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Total floor</th>
                                        <th>Total room</th>
                                        <th>Total seat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ count($building->floor) }}</td>
                                        <td>{{ $building->total_room() }}</td>
                                        <td>{{ $building->total_seat() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-secondary p-3">
                        <h4 class="w-100 text-center text-capitalize">Floor details</h4>
                        @foreach ($building->floor as $floor)
                            <div class="row ml-2">
                                <h4>Floor No-{{$floor->floor}}</h4>
                            </div>
                            <div class="row  mb-3">
                                <div class="col-md-11 m-auto">
                                    <table class="table table-sm table-bordered table-striped table-success">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>Room number</th>
                                                <th>Room name</th>
                                                <th>Total seat </th>
                                                <th>Room details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($floor->room as $key => $room)
                                        <tr>
                                            <td class="align-middle">{{ $room->room }}</td>
                                            <td class="align-middle">{{ $room->name }}</td>
                                            <td class="align-middle">{{ $room->total_seat }}</td>
                                            <td class="align-middle">{!! $room->room_details !!}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                        <h4></h4>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>
@endsection

@push('third_party_scripts')

@endpush

@push('page_scripts')
<script>
    function printT(el) {
        var rp = document.body.innerHTML;
        $('.download').hide();
        var pc = document.getElementById(el).innerHTML;
        document.body.innerHTML = pc;
        window.print();
        document.body.innerHTML = rp;
    }
</script>

@endpush
