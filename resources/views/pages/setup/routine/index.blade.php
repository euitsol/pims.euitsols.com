@extends('layouts.app')

@section('title', 'Routine Management')

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
                        <h4>Routine</h4>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('nationality.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="form-group row">
                                <label class="" for="name">Nationality<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Nationality" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label class="" for="name">Nationality<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Nationality" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label class="" for="name">Nationality<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Nationality" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="guard_name"></label>
                                    <div class="">
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
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

@endpush

@push('page_scripts')
<script>

</script>
@endpush

