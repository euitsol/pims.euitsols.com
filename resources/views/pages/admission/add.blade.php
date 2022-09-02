{{-- Extract master here --}}

@extends('layouts.app')

@section('title', 'User Management')

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
                        <h4>View users</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('users.add') }}" class="btn btn-info">Add new user</a>
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                    <div class="table table-responsive">
                        <table id="table" class="">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $key => $user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($user->created_at)); }}</td>
                                        <td></td>
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
    $('#table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                title: 'User Management',
                download: 'open',
                orientation: 'potrait',
                pagesize: 'LETTER',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            }, 'pageLength'
        ]
    } );
});
</script>
@endpush


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="CJ Inspired">

    <title> @yield('page_title') | {{ config('app.name') }} </title>


    @include('partials.inc_top')
</head>

<body
    class="{{ in_array(Route::currentRouteName(), ['payments.invoice', 'marks.tabulation', 'marks.show', 'ttr.manage', 'ttr.show']) ? 'sidebar-xs' : '' }}">

    {{-- Extract top menu here --}}
    <div class="navbar navbar-expand-md navbar-dark">
        <div class="mt-2 mr-5">
            <a href="{{ route('dashboard') }}" class="d-inline-block">
                {{-- <h4 class="text-bold text-white">{{ Qs::getSystemName() }}</h4> --}}
            </a>
        </div>


        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                        <i class="icon-paragraph-justify3"></i>
                    </a>
                </li>


            </ul>

            <span class="navbar-text ml-md-3 mr-md-auto"></span>

            <ul class="navbar-nav">

                <li class="nav-item dropdown dropdown-user">

                </li>
            </ul>
        </div>
    </div>

    <div class="page-content">
        {{-- @include('partials.menu') --}}
        <div class="content-wrapper">

            {{-- Extracting  header --}}
            <div id="page-header" class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-plus-circle2 mr-2"></i> <span
                                class="font-weight-semibold">@yield('page_title')</span></h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i
                                class="icon-more"></i></a>
                    </div>

                    <div class="header-elements d-none">
                        <div class="d-flex justify-content-center">

                        </div>
                    </div>
                </div>


            </div>

            <div class="content">
                {{-- Error Alert Area --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>

                        @foreach ($errors->all() as $er)
                            <span><i class="icon-arrow-right5"></i> {{ $er }}</span> <br>
                        @endforeach

                    </div>
                @endif
                <div id="ajax-alert" style="display: none"></div>


                {{-- extracting content here --}}
                <div class="card">
                    <div class="card-header bg-white header-elements-inline">
                        <h6 class="card-title">Please fill The form Below To Admit A New Student</h6>

                        {{-- {!! Qs::getPanelOptions() !!} --}}
                    </div>

                    <form id="ajax-reg" method="post" enctype="multipart/form-data"
                        class="wizard-form steps-validation" action="{{ route('admission.store') }}" data-fouc>
                        @csrf
                        <h6>Department Choice</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="bg_id">Department Name: </label>
                                        <select class="select form-control" id="department" name="Departments_id" data-fouc
                                            data-placeholder="Choose..">
                                            <option value="">Select Department</option>
                                            @foreach (App\Models\departmentModel::all() as $d)
                                                <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <h6>Personal data</h6>
                        <fieldset>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name: <span class="text-danger">*</span></label>
                                        <input value="{{ old('name') }}" required type="text" name="name"
                                            placeholder="Full Name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Father's Name: <span class="text-danger">*</span></label>
                                        <input value="{{ old('father_name') }}" required type="text"
                                            name="father_name" placeholder="Father's Name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mother's Name: <span class="text-danger">*</span></label>
                                        <input value="{{ old('mother_name') }}" required type="text"
                                            name="mother_name" placeholder="Mother's Name" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Present Address: <span class="text-danger">*</span></label>
                                        <input value="{{ old('present_address') }}" required class="form-control"
                                            placeholder="Present Address" name="present_address" type="text"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Parmanent Address: <span class="text-danger">*</span></label>
                                        <input value="{{ old('address') }}" required class="form-control"
                                            placeholder="Parmanent Address" name="address" type="text" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email address: </label>
                                        <input type="email" value="{{ old('email') }}" name="email"
                                            class="form-control" placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Phone: <span class="text-danger">*</span></label>
                                        <input value="{{ old('phone') }}" required type="text" name="phone"
                                            class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">Gender: <span class="text-danger">*</span></label>
                                        <select class="select form-control" id="gender" name="gender" required
                                            data-fouc data-placeholder="Choose..">
                                            <option value=""></option>
                                            <option {{ old('gender') == 'Male' ? 'selected' : '' }} value="Male">
                                                Male</option>
                                            <option {{ old('gender') == 'Female' ? 'selected' : '' }} value="Female">
                                                Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Guardian Phone:</label>
                                        <input value="{{ old('phone2') }}" type="text" name="phone2"
                                            class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date of Birth: <span class="text-danger">*</span></label>
                                        <input name="dob" value="{{ old('dob') }}" required type="date"
                                            class="form-control date-pick" placeholder="Select Date...">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nal_id">Nationality: <span class="text-danger">*</span></label>
                                        <input name="nationality" value="{{ old('nationality') }}" required
                                            type="string" class="form-control date-pick"
                                            placeholder="Write Here your Nationality.">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bg_id">Blood Group: </label>
                                        <select class="select form-control" id="bg_id" name="blood_group_name"
                                            data-fouc data-placeholder="Choose..">
                                            <option value=""></option>
                                            @foreach (App\Models\BloodGroup::all() as $bg)
                                                <option {{ old('blood_roup_name') == $bg->id ? 'selected' : '' }}
                                                    value="{{ $bg->id }}">{{ $bg->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Quota</label>
                                        <input name="Quota" value="{{ old('Quota') }}" type="text"
                                            class="form-control date-pick" placeholder="">
                                    </div>
                                </div>
                            </div>

                        </fieldset>


                        <h6>Student Data</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my_class_id">Exam Name: <span class="text-danger">*</span></label>
                                        <select onchange="getClassSections(this.value)" data-placeholder="Choose..."
                                            required name="exam_name" id="my_class_id" class="form-control">
                                            <option value="">Select Your Exam Name</option>
                                            <option value="S.S.C">S.S.C</option>
                                            <option value="H.S.C">H.S.C</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="section_id">Passing Year: <span
                                                class="text-danger">*</span></label>
                                        <select data-placeholder="Choose.." required name="passing_year"
                                            id="section_id" class="form-control">
                                            <option value="">Select Your Passing Year</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my_parent_id">Division: <span class="text-danger">*</span></label>
                                        <select data-placeholder="Choose..." required name="division"
                                            id="my_parent_id" class="form-control">
                                            <option value="">Select Your Division</option>
                                            <option value="Science">Science</option>
                                            <option value="Bussiness Studies">Bussiness Studies</option>
                                            <option value="Humanities">Humanities</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year_admitted">Board: <span class="text-danger">*</span></label>
                                        <select data-placeholder="Choose..." required name="board"
                                            id="year_admitted" class="form-control">
                                            <option value="">Select Education Board</option>
                                            <option value="Dhaka">Dhaka</option>
                                            <option value="Jeshore">Jeshore</option>
                                            <option value="Comilla">Comilla</option>
                                            <option value="Barisal">Barisal</option>
                                            <option value="Sylhet">Sylhet</option>
                                            <option value="Rajshahi">Rajshahi</option>
                                            <option value="Chittagong">Chittagong</option>
                                            <option value="Madrasah Education Board">Madrasah Education Board</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Roll: <span class="text-danger">*</span></label>
                                        <input type="text" required name="roll"
                                            placeholder="Inter Your Roll Number" class="form-control"
                                            value="{{ old('roll') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Registration No: <span class="text-danger">*</span></label>
                                        <input type="text" required name="registration_no"
                                            placeholder="Insert Your Registration Number" class="form-control"
                                            value="{{ old('registration_no') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>G.P.A: <span class="text-danger">*</span></label>
                                        <input type="text" required name="gpa" placeholder="Enter Your G.P.A"
                                            class="form-control" value="{{ old('CGP') }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>


                        <h6>Document Upload</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="d-block">Upload Registration Card: <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ old('reg_card_photo') }}" required accept=".pdf,.png,.jpg"
                                            type="file" name="reg_card" class="form-input-styled" data-fouc>
                                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size
                                            2Mb</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="d-block">Marksheet: <span class="text-danger">*</span></label>
                                        <input value="{{ old('marksheet') }}" required accept=".pdf,.png,.jpg"
                                            type="file" name="marksheet" class="form-input-styled" data-fouc>
                                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size
                                            2Mb</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="d-block">Personal Photo: <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ old('photo') }}" required accept=".pdf,.png,.jpg"
                                            type="file" name="photo" class="form-input-styled" data-fouc>
                                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size
                                            2Mb</span>
                                    </div>
                                </div>

                            </div>
                        </fieldset>

                        {{-- <button type="submit">Submit</button> --}}

                    </form>
                </div>

                {{-- End extracting --}}
                {{-- @yield('content') --}}




            </div>


        </div>
    </div>

    <!-- Theme JS files -->
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }} "></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }} "></script>

    {{-- Forms --}}
    <script src="{{ asset('global_assets/js/plugins/forms/wizards/steps.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/inputs/inputmask.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/validation/validate.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/cookie.js') }}"></script>

    {{-- Notify --}}
    <script type="text/javascript" src="{{ asset('global_assets/js/plugins/notifications/sweet_alert2.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('global_assets/js/plugins/notifications/pnotify.min.js') }}"></script>

    {{-- DataTables --}}
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>

    {{-- Date Pickers --}}
    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/legacy.js') }}"></script>

    {{-- Uploaders --}}
    <script src="{{ asset('global_assets/js/plugins/uploaders/fileinput/fileinput.min.js') }}"></script>

    {{-- Calendar --}}
    <script src="{{ asset('global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js') }}"></script>


    <script src=" {{ asset('assets/js/app.js') }} "></script>
    <script src="{{ asset('global_assets/js/demo_pages/form_wizard.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/form_select2.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/datatables_extension_buttons_html5.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/uploader_bootstrap.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/fullcalendar_basic.js') }}"></script>

    <!-- /theme JS files -->

    {{-- <script src=" {{ asset('assets/js/custom.js') }} "></script> --}}


    {{-- @include('partials.js.custom_js') --}}


    {{-- @include('partials.inc_bottom') --}}
    @yield('scripts')
</body>

</html>
{{-- @extends('layouts.master') --}}
{{-- End extracting master --}}

@section('page_title', 'Admit Student')

{{-- @section('content')

@endsection --}}
