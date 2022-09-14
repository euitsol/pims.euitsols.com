@extends('layouts.app')

@section('title', 'Admitted student')

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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Registration</h4>
                    </span>
                    <span class="float-right">
                        <button type="button" onclick="printT('registration-form')" class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Registration Form </button>
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')
                    <div id="registration-form">
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
                                <h2 class="text-center text-white py-2">Registration Form</h2>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <table class="table _table table-borderless">
                                    <tr>
                                        <td>Student ID</td>
                                        <td>:</td>
                                        <td>{{$student->id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Full Name</td>
                                        <td>:</td>
                                        <td>{{$student->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Father's Name</td>
                                        <td>:</td>
                                        <td>{{$student->father_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Mother's Name</td>
                                        <td>:</td>
                                        <td>{{$student->mother_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>:</td>
                                        <td>{{$student->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{$student->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{$student->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Guardian's Phone</td>
                                        <td>:</td>
                                        <td>{{$student->gardian_phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td>:</td>
                                        <td>{{ date('d-m-Y', strtotime($student->dob)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nationality</td>
                                        <td>:</td>
                                        <td>{{ $student->nationality }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table _table table-borderless">
                                    <tr>
                                        <td colspan="3">
                                            <img class="student-photo" src="{{ \Illuminate\Support\Facades\Storage::url($student->photo) }}" alt="{{$student->name}}" title="{{$student->name}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td>:</td>
                                        <td>{{ $student->department->department_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Blood Group</td>
                                        <td>:</td>
                                        <td>{{ $student->bloodGroup->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>District</td>
                                        <td>:</td>
                                        <td>{{ $student->district->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Division</td>
                                        <td>:</td>
                                        <td>{{ $student->division->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Present Address</td>
                                        <td>:</td>
                                        <td>{{ $student->present_address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Permanent Address</td>
                                        <td>:</td>
                                        <td>{{ $student->parmanent_address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quota</td>
                                        <td>:</td>
                                        <td>{{ $student->quota ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

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
        var pc = document.getElementById(el).innerHTML;
        document.body.innerHTML = pc;
        window.print();
        document.body.innerHTML = rp;
    }
</script>

@endpush
