@extends('layouts.app')

@section('title', 'Registration Form of Admitted Employee')

@push('third_party_stylesheets')

@endpush

@push('page_css')
<style>
    .registration-title h2 {
        background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 2%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 90%);
    }

    .employee-photo{
        height: 125px;
        width: 50%;
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
                        @if ($employee->id)
                            <h4>Employee Details</h4>
                        @else
                            <h4>Employee Information</h4>
                        @endif
                    </span>
                    <span class="float-right">
                        @if ($employee->employee_id)
                        <button type="button" onclick="printT('registration-form')" class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Employee Details </button>
                        {{-- <a href="{{ route('employee.new_employee.index') }}" class="btn btn-secondary btn-sm">Back</a> --}}
                        @else
                            <button type="button" onclick="printT('registration-form')" class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Employee Information </button>
                            <a href="
                            {{ route('employee.admitted.decline.d', $employee->id) }}
                            " class="btn btn-danger btn-sm" title="Decline Regestration" onclick="alert('Are you sure you want to decline?')"><i class="fas fa-user-times"></i></a>
                            <a href="{{ route('employee.admitted.accept.d', $employee->id) }}" class="btn btn-info btn-sm" title="Accept Regestration"><i class="fas fa-user-check"></i></a>
                            <a href="{{ route('employee.new_employee.index') }}" class="btn btn-secondary btn-sm">Back</a>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')
                    <div id="registration-form" style="padding: 0%;">
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
                                <h2 class="text-center text-white py-2">Employee Information</h2>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <table class="table _table table-borderless">
                                    <tr>
                                        <td>Employee ID</td>
                                        <td>:</td>
                                        <td>@if ($employee->employee_id)
                                                {{$employee->employee_id}}
                                                @else
                                                {{'Not assigned'}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Full Name</td>
                                        <td>:</td>
                                        <td>{{$employee->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Father's Name</td>
                                        <td>:</td>
                                        <td>{{$employee->father_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Mother's Name</td>
                                        <td>:</td>
                                        <td>{{$employee->mother_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>:</td>
                                        <td>{{$employee->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td>Marital Status</td>
                                        <td>:</td>
                                        <td>{{$employee->marital_status}}</td>
                                    </tr>
                                    @if($employee->marital_status == 'married')
                                        <tr>
                                            <td>Spouse Name</td>
                                            <td>:</td>
                                            <td>{{$employee->spouse_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Spouse Number</td>
                                            <td>:</td>
                                            <td>{{$employee->spouse_number}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{$employee->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{$employee->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td>:</td>
                                        <td>{{ date('d-m-Y', strtotime($employee->dob)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nationality</td>
                                        <td>:</td>
                                        <td>{{ $employee->nationality }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table _table table-borderless">
                                    <tr>
                                        <td>Employee Photo</td>
                                        <td>:</td>
                                        <td>
                                            @if($employee->photo != null)
                                            <img class="employee-photo" src="{{ \Illuminate\Support\Facades\Storage::url($employee->photo) }}" alt="{{$employee->name}}" title="{{$employee->name}}">
                                            @elseif($employee->gender == 'Male')
                                            <img class="employee-photo" src="{{ asset('assets/image/default/male-employee.png') }}" alt="{{$employee->name}}" title="{{$employee->name}}">
                                            @elseif($employee->gender == 'Female')
                                            <img class="employee-photo" src="{{ asset('assets/image/default/female-employee.png') }}" alt="{{$employee->name}}" title="{{$employee->name}}">
                                            @else
                                            <img class="employee-photo" src="{{ asset('assets/image/default/other-employee.png') }}" alt="{{$employee->name}}" title="{{$employee->name}}">
                                            @endif


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td>:</td>
                                        <td>{{ $employee->department->department_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Blood Group</td>
                                        <td>:</td>
                                        <td>{{ $employee->bloodGroup->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>District</td>
                                        <td>:</td>
                                        <td>{{ $employee->district->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Division</td>
                                        <td>:</td>
                                        <td>{{ $employee->division->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Present Address</td>
                                        <td>:</td>
                                        <td>{{ $employee->present_address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Permanent Address</td>
                                        <td>:</td>
                                        <td>{{ $employee->parmanent_address }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3 clr">
                            <table class="table table-bordered text-center ">
                                <h3 class="text-center mb-3">Employee Academic Information</h3>
                                <thead>
                                    <tr class="">
                                        <th>Exam name</th>
                                        <th>Board</th>
                                        <th>Group</th>
                                        <th>Roll</th>
                                        <th>Registration</th>
                                        <th>Passing Year</th>
                                        <th>GPA</th>
                                        <th class="download">Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->employeeAcademicInfo as $ac)
                                    <tr class="">
                                        <td>{{ optional($ac->exam)->name }}</td>
                                        <td>{{ optional($ac->board)->name }}</td>
                                        <td>{{ $ac->group }}</td>
                                        <td>{{ $ac->roll }}</td>
                                        <td>{{ $ac->reg_no }}</td>
                                        <td>{{ $ac->passing_year }}</td>
                                        <td>{{ number_format((float)$ac->gpa, 2, '.', ''); }}</td>
                                        <td class="download">
                                            <a target="_blank" href="{{ route('employee.reg.download', $ac->id) }}" class="btn btn-sm btn-success" title="Download registration info"><i class="fas fa-download"></i></a>
                                            <a target="_blank" href="{{ route('employee.marksheet.download', $ac->id) }}" class="btn btn-sm btn-success" title="Download marksheet info"><i class="fas fa-file-download"></i></a>
                                            <a target="_blank" href="{{ route('employee.certificate.download', $ac->id) }}" class="btn btn-sm btn-success" title="Download certificate info"><i class="fas fa-download"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 clr">
                            <table class="table table-bordered text-center ">
                                <h3 class="text-center mb-3">Employee Experieces</h3>
                                <thead>
                                    <tr class="">
                                        <th>Designation</th>
                                        <th>Company Name</th>
                                        <th>Job Duration</th>
                                        <th class="download">Download Experience Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->employeeExperience as $ee)
                                    <tr class="">
                                        <td>{{ $ee->designation }}</td>
                                        <td>{{ $ee->company_name }}</td>
                                        <td>{{ $ee->job_start .' - '. $ee->job_end  }}</td>
                                        <td class="download">
                                            <a target="_blank" href="{{ route('employee.ex_certificate.download', $ee->id) }}" class="btn btn-sm btn-success" title="Download Experience Certificate"><i class="fas fa-download"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 clr">
                            <table class="table table-bordered text-center ">
                                <h3 class="text-center mb-3">Employee Documents</h3>
                                <thead>
                                    <tr class="">
                                        <th>Designation</th>
                                        <th class="download">Download NID or DOB</th>
                                        <th class="download">Download CV</th>
                                        <th class="download">Download Character Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->employeeDocument as $ed)
                                    <tr class="">
                                        <td>{{ $ed->designation->name }}</td>
                                        <td class="download">
                                            <a target="_blank" href="{{ route('employee.nid_or_dob.download', $ed->id) }}" class="btn btn-sm btn-success" title="Download NID or Birth Certificate"><i class="fas fa-download"></i></a>
                                        </td>
                                        <td class="download">
                                            <a target="_blank" href="{{ route('employee.cv.download', $ed->id) }}" class="btn btn-sm btn-success" title="Download CV info"><i class="fas fa-download"></i></a>
                                        </td>
                                        <td class="download">
                                            <a target="_blank" href="{{ route('employee.cc.download', $ed->id) }}" class="btn btn-sm btn-success" title="Download Character Certificate"><i class="fas fa-download"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        

                        <div class="row offset-md-1 mt-5 mb-3">
                            <div class="col-md-10">
                                <p class="text-center w-84 font-italic">
                                <i class="fas fa-quote-left quote"></i> The above information is true to the
                                    best of my knowledge.  I authorized {{ env('INSTITUTE_NAME') }}
                                    of Bangladesh to release any information required to process my
                                    claims. <i class="fas fa-quote-right quote"></i>
                                </p>
                            </div>
                        </div>

                        <div class="row justify-content-between mt-5">
                            <p class="border-top" style="margin-left: 5%;">Authorized Signature</p>
                            <p class="border-top" style="margin-right: 5%;">Employee Signature</p>
                        </div>

                        {{-- <div class="row justify-content-center mt-5">
                            <p class="">{{ env('APP_URL') }}</p>
                        </div> --}}

                    </div>

                </div>
            </div>

            {{-- Employee's semester information --}}
            
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



{{-- <script>
    function phnCheck()
    {
        var a = document.getElementById("gardian_phone").value;
        var b = document.getElementById("phone").value;

        if(a.length !== 11 && a.length)
        {
            alert("Invalid Guardian phone number");
            return false;
        }
        if(b.length !== 11 && b.length)
        {
            alert("Invalid Guardian phone number");
            return false;
        }
        console.log(a);
    }
</script> --}}

@endpush
