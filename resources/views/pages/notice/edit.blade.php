@extends('layouts.master')
@section('page_title', 'Edit Class Room - '.$data->notice_title)
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Edit Notice</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="ajax-update" data-reload="#page-header" enctype="multipart/form-data" method="post" action="{{ route('notice.update', $data->id) }}">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Notice Title:<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="notice_title" value="{{ $data->notice_title }}" required type="text" class="form-control" placeholder="Notice Title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Notice file:<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="notice_file" value="{{ $data->notice_file }}" accept=".pdf" required type="file" class="form-control" placeholder="Notice file">
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
