@extends('layouts.app')

@section('title', 'Grade Calculation Management')

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
                            <h4>Add Grade Calculation</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('grade.index') }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <form action="{{ route('grade.store') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="role">Grade<span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <select class="form-control" name="grade" id="grade">
                                                @foreach ($letter_grades as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('grade'))
                                                <span class="text-danger">{{ $errors->first('grade') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="mark_start">Marks<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-daterange" id="mark">
                                                <input type="number" class="form-control" id="mark_start"
                                                    name="mark_start" value="{{ old('mark_start') }}" step="0.01" required>



                                                <div class="input-group-append">
                                                    <div class="input-group-text">to</div>
                                                </div>
                                                <input type="number" class="form-control" id="mark_end" name="mark_end" step="0.01" value="{{ old('mark_end') }}">
                                            </div>

                                            @if ($errors->has('mark_end'))
                                                    <span class="text-danger">{{ $errors->first('mark_end') }}</span>

                                                @elseif ($errors->has('mark_start'))
                                                    <span class="text-danger">{{ $errors->first('mark_start') }}</span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="grade_point">Grade Point<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="credit_number"
                                                name="grade_point" value="{{ old('grade_point') }}" step=".01"
                                                placeholder="Enter Grade Point" required>
                                            @if ($errors->has('grade_point'))
                                                <span class="text-danger">{{ $errors->first('grade_point') }}</span>
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
