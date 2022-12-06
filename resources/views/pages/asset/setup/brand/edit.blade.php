@extends('layouts.app')

@section('title', 'Asset Management - Edit Brand')


@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit {{$brand->name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('asset-setup-brand view') || Auth::user()->role->id == 1)<a href="{{ route('asset.setup.brand.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('asset.setup.brand.update') }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{$brand->id}}">
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Brand Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter brand name" value="{{$brand->name}}" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="img">Image<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" name="img" id="img" value="{{ old('img') }}" required>
                                        @if ($errors->has('img'))
                                            <span class="text-danger">{{ $errors->first('img') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="create"></label>
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

