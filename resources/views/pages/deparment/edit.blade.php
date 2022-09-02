@extends('layouts.master')
{{-- @dd($data_update) --}}
@section('page_title', 'Edit Class - '.$data_update->department_name)
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Edit Deparment</h6>
            {!! Qs::getPanelOptions() !!}
        </div>
{{-- @dd($data_update->id) --}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="ajax-update" data-reload="#page-header" method="post" action="{{ route('departments.update', $data_update->id) }}">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Department Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="name" value="{{ $data_update->department_name }}" required type="text" class="form-control" placeholder="Name of Deparment">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="slug" class="col-lg-3 col-form-label font-weight-semibold">Short Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input id="slug" required name="short_name" value="{{ $data_update->short_name}}" type="text" class="form-control" placeholder="Eg. B.Eng">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--Class Edit Ends--}}

@endsection
