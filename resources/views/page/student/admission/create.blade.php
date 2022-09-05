@extends('layouts.app')

@section('title', 'Admit Student')

@push('third_party_stylesheets')

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
                        <h4>Add {{$page_name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('user view') || Auth::user()->role->id == 1)<a href="{{ route('users.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('department.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <h2 class="text-center">Department Choice</h2>
                            <fieldset>
                                <div class="row index1">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="bg_id">Department Name: </label>
                                            <select class="select form-control" id="department" name="Departments_id" data-fouc
                                                data-placeholder="Choose..">
                                                <option value="">Select Department</option>
                                                @foreach (App\Models\Department::all() as $d)
                                                    <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <h2 class="text-center">Personal data</h2>
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Mother's Name: <span class="text-danger">*</span></label>
                                            <input value="{{ old('mother_name') }}" required type="text"
                                                name="mother_name" placeholder="Mother's Name" class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Present Address: <span class="text-danger">*</span></label>
                                            <input value="{{ old('present_address') }}" required class="form-control"
                                                placeholder="Present Address" name="present_address" type="text"
                                                required>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Parmanent Address: <span class="text-danger">*</span></label>
                                            <input value="{{ old('parmanent_address') }}" required class="form-control"
                                                placeholder="Parmanent Address" name="parmanent_address" type="text" required>
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
                                            <input value="{{ old('gardian_phone') }}" type="text" name="gardian_phone"
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
                                            <select class="select form-control" id="bg_id" name="bg_name"
                                                data-fouc data-placeholder="Choose..">
                                                <option value="">Select Blood Group</option>
                                                {{-- @foreach (App\Models\BloodGroup::all() as $bg)
                                                    <option {{ old('bg_name') == $bg->id ? 'selected' : '' }}
                                                        value="{{ $bg->id }}">{{ $bg->bg_name }}</option>
                                                @endforeach --}}
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="d-block">Photo: <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('photo') }}" required accept=".pdf,.png,.jpg"
                                                type="file" name="photo" class="form-input-styled" data-fouc>
                                            <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size
                                                2Mb</span>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>


                            <h2 class="text-center">Academic Information</h2>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="my_class_id">Exam Name: <span class="text-danger">*</span></label>
                                            <select onchange="getClassSections(this.value)" data-placeholder="Choose..."
                                                required name="exam_name" id="my_class_id" class="form-control">
                                                <option value="">Select Your Exam Name</option>
                                                {{-- @foreach (App\Models\BloodGroup::all() as $n)
                                                    <option {{ old('blood_roup_name') == $bg->id ? 'selected' : '' }}
                                                        value="{{ $n->id }}">{{ $n->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="section_id">Passing Year: <span
                                                    class="text-danger">*</span></label>
                                            <select data-placeholder="Choose.." required name="passing_year"
                                                id="section_id" class="form-control">
                                                <option value="">Select Your Passing Year</option>
                                                {{-- @foreach (App\Models\BloodGroup::all() as $n)
                                                    <option {{ old('blood_roup_name') == $n->id ? 'selected' : '' }}
                                                        value="{{ $n->id }}">{{ $n->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="year_admitted">Board: <span class="text-danger">*</span></label>
                                            <select data-placeholder="Choose..." required name="board"
                                                id="year_admitted" class="form-control">
                                                <option value="">Select Education Board</option>
                                                {{-- @foreach (App\Models\BloodGroup::all() as $n)
                                                    <option {{ old('blood_roup_name') == $n->id ? 'selected' : '' }}
                                                        value="{{ $n->id }}">{{ $n->name }}</option>
                                                @endforeach --}}
                                                {{-- <option value="Dhaka">Dhaka</option>
                                                <option value="Jeshore">Jeshore</option>
                                                <option value="Comilla">Comilla</option>
                                                <option value="Barisal">Barisal</option>
                                                <option value="Sylhet">Sylhet</option>
                                                <option value="Rajshahi">Rajshahi</option>
                                                <option value="Chittagong">Chittagong</option>
                                                <option value="Madrasah Education Board">Madrasah Education Board</option> --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Roll: <span class="text-danger">*</span></label>
                                            <input type="text" required name="roll"
                                                placeholder="Inter Your Roll Number" class="form-control"
                                                value="{{ old('roll') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Registration No: <span class="text-danger">*</span></label>
                                            <input type="text" required name="registration_no"
                                                placeholder="Insert Your Registration Number" class="form-control"
                                                value="{{ old('registration_no') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>G.P.A: <span class="text-danger">*</span></label>
                                            <input type="text" required name="gpa" placeholder="Enter Your G.P.A"
                                                class="form-control" value="{{ old('CGP') }}">
                                        </div>
                                    </div>

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
                                    <button type="button" class="btn btn-primary">Add Another Academic information</button>
                                </div>
                            </fieldset>
                            <div class="col-md-12  text-right">
                                <button type="button" class="btn btn-success">Submit</button>
                            </div>
                            </form>
                        </div>
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

</script>
@endpush

