@extends('layouts.app')

@section('title', 'Asset Management - Edit unit')


@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit {{$unit->name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('asset-setup-unit view') || Auth::user()->role->id == 1)<a href="{{ route('asset.setup.unit.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('asset.setup.unit.update') }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{$unit->id}}">
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Unit Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter unit name" value="{{$unit->name}}" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="short_name">Short name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="short_name" id="short_name" value="{{ $unit->short_name }}" placeholder="Enter unit short name" required>
                                        @if ($errors->has('short_name'))
                                            <span class="text-danger">{{ $errors->first('short_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="base_unit_id">Base unit<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">

                                        <select name="base_unit_id" id="base_unit_id" class="form-control">
                                            <option value="hidden">Select base unit</option>
                                            @foreach ($base_units as $base_unit)
                                                <option value="{{$base_unit->id}}" @if($unit->base_unit_id == $base_unit->id) selected @endif>{{$base_unit->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('base_unit_id'))
                                            <span class="text-danger">{{ $errors->first('base_unit_id') }}</span>
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

