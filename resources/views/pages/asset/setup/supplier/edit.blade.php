@extends('layouts.app')

@section('title', 'Asset Management - Edit Supplier')


@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit {{$supplier->name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('asset-setup-supplier view') || Auth::user()->role->id == 1)<a href="{{ route('asset.setup.supplier.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('asset.setup.supplier.update') }}" method="POST" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="id" value="{{$supplier->id}}">

                            <div class="form-group row">
                                <label class="col-sm-3" for="shop_name">Shop Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="shop_name" id="shop_name" value="{{ $supplier->shop_name }}" placeholder="Enter supplier shop name" required>
                                    @if ($errors->has('shop_name'))
                                        <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3" for="owner_name">Owner Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="owner_name" id="owner_name" value="{{ $supplier->owner_name }}" placeholder="Enter supplier owner name" required>
                                    @if ($errors->has('owner_name'))
                                        <span class="text-danger">{{ $errors->first('owner_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="phone">Phone<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="phone" id="phone" value="{{ $supplier->phone }}" placeholder="Enter supplier phone" required>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="email">E-mail<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="tel" name="email" id="email" value="{{ $supplier->email ?? '' }}" placeholder="Enter supplier E-mail" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="address">Address<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Enter supplier address" required>{!! $supplier->address !!}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="details">Details</label>
                                <div class="col-sm-9">
                                    <textarea name="details" class="form-control" id="details" cols="30" rows="6" placeholder="Enter supplier details">{!! $supplier->details ?? '' !!}</textarea>
                                    @if ($errors->has('details'))
                                        <span class="text-danger">{{ $errors->first('details') }}</span>
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

