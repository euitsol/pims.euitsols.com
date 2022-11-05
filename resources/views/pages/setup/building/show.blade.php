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
                    {{-- <div id="registration-form" style="padding: 0%;">
                        <div class="row mt-3 d-flex align-items-center">
                            <div class="col-md-3">
                                <img src="{{asset('assets/image/default/site-logo.jpg')}}" height="35"
                                    alt="logo">
                            </div>
                            <div class="col-md-8 offset-1 header-right">
                                <h2 class="text-right  p-0 m-0 font-weight-bold">
                                    European IT Solutions Institute
                                </h2>
                                <p class="text-right p-0 m-0">
                                    Noor Mansion (3rd Floor), Plot#04, Main Road#01, Mirpur-10,
                                    Dhaka-1216
                                </p>
                                <p class="text-right p-0 m-0">
                                    <strong>Mobile:</strong>+880 1741 877 058,
                                    <strong>Phone: </strong> +880 2580 508 45</p>
                                <p class="text-right p-0 m-0">
                                    <strong>Email:</strong> training@euitsols-inst.com,
                                    <strong>Web:</strong> www.euitsols-inst.com
                                </p>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="registration-title col-md-6 offset-md-3">
                                <h2 class="text-center text-white py-2">{{$building->name}}</h2>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <p class="">{{ env('APP_URL') }}</p>
                        </div>

                    </div> --}}
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
                                        <td>{{ count($building->floors()) }}</td>
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
                                                <th>Total seat </th>
                                                <th>Room details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($floor->room as $key => $room)
                                        <tr>
                                            <td>{{ $room->room }}</td>
                                            <td>{{ $room->total_seat }}</td>
                                            <td>{{ $room->room_details }}</td>
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
