@extends('layouts.app')

@section('title', 'Library Management-Bookshelf')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add new bookshelf</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('bookshelf view') || Auth::user()->role->id == 1)<a href="{{ route('library.setup.bookshelf.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('library.setup.bookshelf.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3 " for="name"> Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control text-capitalize" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter bookshelf's name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="capacity"> Capacity<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" placeholder="Enter bookshelf's capacity" required>
                                        @if ($errors->has('capacity'))
                                            <span class="text-danger">{{ $errors->first('capacity') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="details"> Details</label>
                                    <div class="col-sm-9">
                                        <textarea name="details"  id="details" class="form-control" cols="30" rows="6" placeholder="Bookshelf's details"></textarea>
                                        @if ($errors->has('details'))
                                            <span class="text-danger">{{ $errors->first('details') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="create"></label>
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

