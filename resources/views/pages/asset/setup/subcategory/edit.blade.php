@extends('layouts.app')

@section('title', 'Asset Management - Edit Subcategory')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit {{$subcategory->name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('subcategory view') || Auth::user()->role->id == 1)<a href="{{ route('asset.setup.subcategory.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('asset.setup.subcategory.update') }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{$subcategory->id}}">

                            <div class="form-group row">
                                <label class="col-sm-3" for="cat_id">Category<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="cat_id" id="cat_id" class="form-control">
                                        <option value="hidden">Select Category</option>
                                        @foreach ($categories as $category )
                                            <option value="{{$category->id}}" @if($category->id == $subcategory->cat_id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Subcategory Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter subcategory name" value="{{$subcategory->name}}" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="img">Image<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" name="img" id="img" value="{{ old('img') }}">
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

@push('third_party_scripts')
 <script src="{{asset('assets/js/select2/select2.min.js')}}"></script>
@endpush

@push('page_scripts')
    <script>
        $('select').select2();
    </script>
@endpush
