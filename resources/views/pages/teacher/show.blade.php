@extends('layouts.app')

@section('title', 'Teacher Management')

@push('third_party_stylesheets')
    <link href="{{ asset('assets/js/DataTable/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('page_css')
<style>
    .teacher-info-title h2 {
        background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 2%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 90%);
    }
    .teacher-photo{
        height: 500px;
        width: 100%;
        object-fit: contain;
    }
    .clr table tr th {
        background: #ECECEC !important;
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
                            <h4>Teacher Information</h4>
                        </span>
                        <span class="float-right">
                            <button type="button" onclick="printT('teacher-info-form')" class="btn btn-dark btn-sm"><i
                                    class="fa fa-print"></i> Teacher Information </button>
                            <a href="{{ route('teacher.index') }}" class="btn btn-secondary btn-sm">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <div id="teacher-info-form" style="padding: 0%;">
                            <div class="row mt-3 d-flex align-items-center">
                                <div class="col-md-3">
                                    <img src="https://pims.euitsols.com/assets/image/default/site-logo.jpg" height="35"
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
                                        <strong>Phone: </strong> +880 2580 508 45
                                    </p>
                                    <p class="text-right p-0 m-0">
                                        <strong>Email:</strong> training@euitsols-inst.com,
                                        <strong>Web:</strong> www.euitsols-inst.com
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="teacher-info-title col-md-6 offset-md-3">
                                    <h2 class="text-center text-white py-2">{{$db_data->name}}'s Information</h2>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-8">
                                    <table class="table _table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>Teacher's Name</td>
                                                <td>:</td>
                                                <td>{{$db_data->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Department</td>
                                                <td>:</td>
                                                <td>{{$db_data->department->department_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Division</td>
                                                <td>:</td>
                                                <td>{{$db_data->division->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>District</td>
                                                <td>:</td>
                                                <td>{{$db_data->district->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Blood Group</td>
                                                <td>:</td>
                                                <td>{{$db_data->bloodgroup->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Date of Birth</td>
                                                <td>:</td>
                                                <td>{{ $db_data->date_of_birth }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $db_data->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>:</td>
                                                <td>{{ $db_data->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>NID</td>
                                                <td>:</td>
                                                <td>{{ $db_data->nid }}</td>
                                            </tr>
                                            <tr>
                                                <td>Gender</td>
                                                <td>:</td>
                                                <td>{{ $db_data->gender }}</td>
                                            </tr>
                                            <tr>
                                                <td>Present Address</td>
                                                <td>:</td>
                                                <td>{{ $db_data->present_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Permanant Address</td>
                                                <td>:</td>
                                                <td>{{ $db_data->permanant_address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td colspan="3">
                                                    <img class="teacher-photo"
                                                        src="{{ \Illuminate\Support\Facades\Storage::url($db_data->photo) }}"
                                                        alt="a" title="a">

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- <div class="row offset-md-1 mt-5 mb-3">
                                <div class="col-md-10">
                                    <p class="text-center w-84 font-italic">
                                        <i class="fas fa-quote-left quote"></i> The above information is true to the
                                        best of my knowledge. I authorized {{ env('INSTITUTE_NAME') }}
                                        of Bangladesh to release any information required to process my
                                        claims. <i class="fas fa-quote-right quote"></i>
                                    </p>
                                </div>
                            </div> --}}

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
