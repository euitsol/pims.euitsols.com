@extends('layouts.app')

@section('title', 'Asset Management - Add Supplier')

@push('third_party_stylesheets')
@endpush
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add new supplier</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('asset-setup-supplier view') || Auth::user()->role->id == 1)<a href="{{ route('asset.setup.supplier.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('asset.setup.supplier.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3" for="shop_name">Shop Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="shop_name" id="shop_name" value="{{ old('shop_name') }}" placeholder="Enter supplier shop name" required>
                                        @if ($errors->has('shop_name'))
                                            <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="owner_name">Owner Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" placeholder="Enter supplier owner name" required>
                                        @if ($errors->has('owner_name'))
                                            <span class="text-danger">{{ $errors->first('owner_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="phone">Phone<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter supplier phone" onfocusout="phoneNumberChk()" required>
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                        <span class="text-danger" id="phn"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="email">E-mail<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter supplier E-mail" required>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="address">Address<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Enter supplier address" required>{{ old('address') }}</textarea>
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="details">Details</label>
                                    <div class="col-sm-9">
                                        <textarea name="details" class="form-control" id="details" cols="30" rows="6" placeholder="Enter supplier details">{{ old('details') }}</textarea>
                                        @if ($errors->has('details'))
                                            <span class="text-danger">{{ $errors->first('details') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="create"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary w-100" id="addSupplier" onclick="phnNumberPost()">Add</button>
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
 <script src="{{asset('assets/js/pond/filepond.min.js')}}"></script>
@endpush

@push('page_scripts')

<script>
    function phoneNumberChk()
    {

        var phone = document.getElementById("phone").value;


        if(phone.length !== 11 || (phone === ''))
        {
            document.getElementById("phn").textContent = "Invalid Phone number";
            document.getElementById("addTeacher").disabled = true;
        }
        else if(phone.length === 11)
        {
            document.getElementById("phn").textContent = "";

        }
        if((phone.length === 11))
        {
            document.getElementById("addSupplier").disabled = false;
        }
    }

    function phnNumberPost()
    {

        var phone = document.getElementById("phone").value;

        if((phone.length !== 11 || phone === ''))
        {
            document.getElementById("addSupplier").disabled = true;
            document.getElementById("phn").textContent = "Invalid Phone number";
        }
    }

</script>

@endpush

