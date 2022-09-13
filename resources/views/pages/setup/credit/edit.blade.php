@extends('layouts.app')

@section('title', 'Credit Management')

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
                        <h4>Update Credit</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('credit.index') }}" class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('credit.update',$db_data->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{ $db_data->id }}">

                                <div class="form-group row">
                                    <label class="col-sm-3" for="credit_number">Credit Number<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="credit_number" name="credit_number" value="{{ number_format((float)$db_data->credit_number, 2, '.', '')}}" step=".01" placeholder="Enter Credit Number" required>
                                        <small>please enter upto 2 decimal point</small>
                                        @if ($errors->has('credit_number'))
                                            <span class="text-danger">{{ $errors->first('credit_number') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="marks">Marks<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="marks" name="marks" value="{{ $db_data->marks }}" placeholder="Enter shift Name" required>
                                        @if ($errors->has('marks'))
                                            <span class="text-danger">{{ $errors->first('marks') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="class_hour">Class Hour<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9 d-flex">
                                        <input type="number" step="0.01" class="form-control" id="class_hour" value="{{ $db_data->class_hour }}" placeholder="Enter Total Class Hour Per Class" name = "class_hour">
                                        <div class="input-group-append">
                                            <select class="form-control" name="hour_minute" id="hour_minute">
                                                <option value="1" @if( $db_data->hour_minute==1 ) selected @endif >Hours</option>
                                                <option value="2" @if( $db_data->hour_minute==2 ) selected @endif >Minutes</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if ($errors->has('class_hour'))
                                            <span class="text-danger ml-2">{{ $errors->first('class_hour') }}</span>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="total_class">Total Class<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="total_class" name="total_class" value="{{ $db_data->total_class }}" placeholder="Enter shift Name" required>
                                        @if ($errors->has('total_class'))
                                            <span class="text-danger">{{ $errors->first('total_class') }}</span>
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

</script>
@endpush
