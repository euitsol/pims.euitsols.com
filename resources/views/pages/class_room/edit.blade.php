@extends('layouts.master')
@section('page_title', 'Edit Class Room - '.$query_cr_no_edit->class_room_no)
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Edit Semester</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="ajax-update" data-reload="#page-header" method="post" action="{{ route('classRoom.update', $query_cr_no_edit->id) }}">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Class Room No:<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="class_room_no" value="{{ $query_cr_no_edit->class_room_no }}" required type="text" class="form-control" placeholder="Class Room No">
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
