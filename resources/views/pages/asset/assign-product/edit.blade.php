@extends('layouts.app')

@section('title', 'Edit Assigned Product')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/DataTable/datatables.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Edit Assigned Product</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-sm w-50 m-auto">

                            <tbody>
                                <tr>
                                    <th>Department:</th>
                                    <td >{{$main_assign_product->assignProduct->department ? $main_assign_product->assignProduct->department->department_name : 'Common Asset'}}</td>
                                </tr>
                                <tr>
                                    <th>Section:</th>
                                    <td >{{$main_assign_product->assignProduct->section->name ?? 'All'}}</td>
                                </tr>

                                <tr>
                                    <th>Sub-section:</th>
                                    <td >{{$main_assign_product->assignProduct->subsection->name ?? 'All'}}</td>
                                </tr>
                            </tbody>
                        </table>

                           <form action="{{route('asset.assign.product.update')}}" method="POST" class="form mt-4">
                                @csrf
                                <input type="hidden" name="id" value="{{$main_assign_product->id}}">
                                <input type="hidden" name="product_id" value="{{$main_assign_product->product_id}}">
                            <div class="row">
                                <div class="col-md-6 m-auto">
                                    <div class="form-group">
                                        <label for="qty">Quantity</label>
                                       <input type="number" name="qty" class="form-control" value="{{$main_assign_product->qty}}">
                                        @if ($errors->has('qty'))
                                            <span class="text-danger">{{ $errors->first('qty') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-6 m-auto">
                                    <div class="form-group">
                                        <label for="supplier_id">Supplier</label>
                                        <select name="supplier_id" class="form-control" id="supplier_id">
                                            <option value="" hidden>Select Supplier</option>
                                            @foreach ($main_assign_product->product->moreProduct as $d)
                                                    <option value="{{ $d->supplier->id }}"
                                                        @if (old('supplier_id') == $d->supplier->id) selected @endif>
                                                        {{ $d->supplier->shop_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('supplier_id'))
                                            <span class="text-danger">{{ $errors->first('supplier_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4 search">Update</button>
                                </div>
                            </div>
                           </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('third_party_scripts')
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
<script>
    $('select').select2();
</script>
@endpush
