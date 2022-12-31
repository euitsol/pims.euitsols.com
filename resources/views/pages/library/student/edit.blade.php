@extends('layouts.app')

@section('title', 'Library Management - Edit Student')
@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">
@endpush


@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit student</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('library-student view') || Auth::user()->role->id == 1)<a href="{{ route('library.member.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('library.member.update') }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{$student->id}}">
                                {{-- <div class="form-group row">
                                    <label class="col-sm-3" for="name">student Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter student name" value="{{$student->name}}" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter student's name" value="{{$student->name}}" required>
                                        @if($errors->has('name')) <span class="text-danger">{{$errors->first('name')}}</span> @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phone">Phone<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" id="phone" name="phone" placeholder="Enter student's phone" value="{{$student->phone}}" required>
                                        @if($errors->has('phone')) <span class="text-danger">{{$errors->first('phone')}}</span> @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dob">Date of Birth<span class="text-danger">*</span></label>
                                        <input class="form-control date" type="text" id="dob" name="dob" placeholder="Enter student's date of birth" value="{{$student->dob}}">
                                        @if($errors->has('dob')) <span class="text-danger">{{$errors->first('dob')}}</span> @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="ec_name">Emergency contact (name)</label>
                                        <input class="form-control" type="text" id="ec_name" name="ec_name" placeholder="Enter student's emergency contact (name)" value="{{$student->ec_name}}">
                                        @if($errors->has('ec_name')) <span class="text-danger">{{$errors->first('ec_name')}}</span> @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label for="ec_phone">Emergency contact (phone)</label>
                                        <input class="form-control" type="number" id="ec_phone" name="ec_phone" placeholder="Enter student's emergency contact (phone)" value="{{$student->ec_phone}}">
                                        @if($errors->has('ec_phone')) <span class="text-danger">{{$errors->first('ec_phone')}}</span> @endif
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="present_add">Present address<span class="text-danger">*</span></label>
                                        <textarea name="present_add" class="form-control" id="present_add" cols="30" rows="6" placeholder="Enter student's present address" required>{!! $student->present_address !!}</textarea>
                                        @if($errors->has('present_add')) <span class="text-danger">{{$errors->first('present_add')}}</span> @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label for="permanent_add">Permanent address<span class="text-danger">*</span></label>
                                        <textarea name="permanent_add" class="form-control" id="permanent_add" cols="30" rows="6" placeholder="Enter student's parmanent address" required>{!! $student->permanent_address !!}</textarea>
                                        @if($errors->has('permanent_add')) <span class="text-danger">{{$errors->first('permanent_add')}}</span> @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary w-100">Update</button>
                                    </div>
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
    {{-- //datpicker --}}
    <script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                autoclose: true,
            });
        });
    </script>
@endpush
