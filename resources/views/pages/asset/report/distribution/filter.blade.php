@extends('layouts.app')

@section('title', 'Distribution Products Report')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <form action="{{route('asset.report.distribution.fetch')}}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Search</h4>
                            </span>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control" id="department_id">
                                            <option value="all">All</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if (isset($department_id)) @if ($department_id == $department->id) selected @endif
                                                    @endif >
                                                    {{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                            <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section_id">Section</label>
                                        <select name="section_id" class="form-control" id="section_id">
                                            <option value="" hidden>All</option>
                                        </select>
                                        @if ($errors->has('section_id'))
                                            <span class="text-danger">{{ $errors->first('section_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subsection_id">Sub-section</label>
                                        <select name="subsection_id" class="form-control" id="subsection_id">
                                            <option value="" hidden>All</option>
                                        </select>
                                        @if ($errors->has('subsection_id'))
                                            <span class="text-danger">{{ $errors->first('subsection_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-1 offset-md-2">
                                    <label for="date">Date range<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6 text-left ">
                                    <div class="input-group">
                                        <input name="str_date" type="date" id="str_date" class="form-control date"
                                            value="">
                                        <span class="input-group-text">to</span>
                                        <input name="end_date" type="date" id="end_date" class="form-control date"
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4 search">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>

        $(document).ready(function() {
            $('select').select2();

            //Section fetch according to Department
            $("#department_id").change(function() {
                $('#subsection_id').html("<option value='' selected> Select... </option>");
                let department_id = $(this).val();
                ajaxDataFetch('Section', {
                    'department_id': department_id
                }, ['created_user', 'updated_user',
                    'deleted_user', 'department'
                ], null, $('#section_id'));
            });

            //Sub-section fetch according to Section
            $("#section_id").change(function() {
                let section_id = $(this).val();
                ajaxDataFetch('Subsection', {
                    'section_id': section_id
                }, ['created_user', 'updated_user',
                    'deleted_user', 'section'
                ], null, $("#subsection_id"));
            });


        });
    </script>
@endpush


