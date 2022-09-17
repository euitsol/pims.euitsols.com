@extends('layouts.app')

@section('title', 'Subjects Assign Management')

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
                        <h4>Edit Assigned Subject</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('subject-assign.index') }}" class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('subject-assign.update') }}" method="POST" class="form-horizontal">
                            @csrf
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <div class="form-group row">
                                    <label class="col-sm-3" for="session_id">Session<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="session_id" name="session_id" required>
                                            <option value="" hidden>Select Session</option>
                                            @foreach ($session as $n)
                                                <option value="{{ $n->id }}" @if( $data->session->id == $n->id ) selected @endif>{{ $n->start."-".$n->end }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('session_id'))
                                            <span class="text-danger">{{ $errors->first('session_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="department_id">Department<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="department_id" name="department_id" required>
                                            <option value="" hidden>Select Department</option>
                                            @foreach ($department as $n)
                                                <option value="{{ $n->id }}" @if( $data->department->id == $n->id ) selected @endif>{{ $n->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                            <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="subject_id">Subjects<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="subject_id" name="subject_id" required>
                                            <option value="" hidden>Select Subject</option>
                                            @foreach ($subject as $n)
                                                <option value="{{ $n->id }}" @if( $data->subject->id == $n->id ) selected @endif>{{ $n->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('subject_id'))
                                            <span class="text-danger">{{ $errors->first('subject_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="semester_id">Semester<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="semester_id" name="semester_id" required>
                                            <option value="" hidden>Select Semester</option>
                                            @foreach ($semester as $n)
                                                <option value="{{ $n->id }}" @if( $data->semester->id == $n->id ) selected @endif>{{ $n->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('semester_id'))
                                            <span class="text-danger">{{ $errors->first('semester_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="guard_name"></label>
                                    <div class="col-sm-9">
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


@push('page_scripts')
<script>
    $("#department_id").on('change',function(){
        $("#subject_id").prop('disabled',false);
        var id = $(this).val();
        var url = "<?php echo url('/subject-fetch')?>/"+id;

        $.ajax({
             url:url,
             method: 'GET',
             data:{
                id:id
             },
             success:function(response){
                // console.log(response);
                var data = '<option value="" hidden>Select Subject</option>'
                $.each(response,function(index,value){
                    data += '<option value="'+value.id+'")>'+value.name+'</option>'
                });
                // console.log(data);
                $('#subject_id').html(data);
             }
        });
    });
</script>
@endpush

