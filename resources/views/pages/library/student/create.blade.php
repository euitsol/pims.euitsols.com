@extends('layouts.app')

@section('title', 'Library Management - Add student')
@push('page_css')
    <style>

        .tab-content-bg{
            background: white;
        }
        .card-body {
            background-color: #f6f8fa;
        }
       .card-body .nav a{
            background-color: #FFFFC4;
            color: inherit !important;
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
                        <h4>Add new student</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('library-student view') || Auth::user()->role->id == 1)<a href="{{ route('library.student.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="tab-parent p-4 level-1-page">
                        <ul class="nav nav-tabs">
                            <li class="nav-item mr-3 border border-bottom-0 border-pill">
                                <a  class="nav-link active" data-toggle="tab" href="#student">Add a residential Students</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#non_student">Add a non-residential Students</a>
                            </li>
                        </ul>

                        <div class="tab-content tab-content-bg p-4">
                            <div class="tab-pane active" id="student">
                                <form action="">
                                    <div class="row mb-3">
                                        <div class="input-group w-50 m-auto">
                                            <label class="mr-3" for="std_id">Student ID: <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number">
                                        </div>
                                    </div>
                                    <div class="row text-center ">
                                        <p class="mr-5 ml-5"></p>
                                        <button class="btn btn-info w-25 m-auto">Save</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="non_student">
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-6 input-group">
                                            <label for="name">Name</label>
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Enter student's name">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('library.student.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                {{-- <div class="form-group row">
                                    <label class="col-sm-3" for="name">Category Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter category name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="create"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary w-100">Create</button>
                                    </div>
                                </div> --}}

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

