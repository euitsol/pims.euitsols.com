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
                            <h4>Add Credit</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('credit.index') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <form action="{{ route('credit.store') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="credit_number">Credit Number<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="credit_number"
                                                name="credit_number" value="{{ old('credit_number') }}" step=".01"
                                                placeholder="Enter Credit Number" required>
                                            @if ($errors->has('credit_number'))
                                                <span class="text-danger">{{ $errors->first('credit_number') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="marks">Marks<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="marks" name="marks"
                                                value="{{ old('marks') }}" step=".01" placeholder="Enter Total Marks" required>
                                            @if ($errors->has('marks'))
                                                <span class="text-danger">{{ $errors->first('marks') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="class_hour">Class Hour<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9 d-flex">
                                            <input type="number" step="0.01" class="form-control" id="class_hour" value="{{ old('class_hour') }}" placeholder="Enter Total Class Hour Per Class" name = "class_hour">
                                            <div class="input-group-append">
                                                {{-- <span class="input-group-text">.00</span> --}}
                                                <select class="form-control" name="hour_minute" id="hour_minute">
                                                    <option value="1" @if( old('hour_minute') == 1 ) selected @endif >Hours</option>
                                                    <option value="2" @if( old('hour_minute') == 2 ) selected @endif >Minutes</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if ($errors->has('class_hour'))
                                                <span class="text-danger ml-2">{{ $errors->first('class_hour') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="total_class">Total Class<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="total_class" name="total_class"
                                                value="{{ old('total_class') }}" placeholder="Enter Total Class" required>
                                            @if ($errors->has('total_class'))
                                                <span class="text-danger">{{ $errors->first('total_class') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="guard_name"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary w-100">Create</button>
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
    <script></script>
@endpush
