@extends('layouts.app')

@section('title', 'Asset Management - Add Asset')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush
@push('page_css')
    <style>
        .ck-editor__editable{
            height: 174px;
    }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="row w-100 mb-2">
                <div class="col-md-12">
                    <span class="float-left ml-2">
                        <h4>Add new asset</h4>
                    </span>

                    <span class="float-right">
                        @if (Auth::user()->can('asset view') || Auth::user()->role->id == 1)
                            <a href="{{ route('asset.product.index') }}" class="btn btn-info">Back</a>
                        @endif
                    </span>
                </div>
            </div>

            <div class="col-md-10 col-lg-12">
                <form action="{{ route('asset.product.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    {{--All Asset details Asset details  --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-11 m-auto">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Asset Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name" id="name"
                                                    value="{{ old('name') }}" placeholder="Enter asset name" required>
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif

                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="qty">Quantity<span class="text-danger">*</span></label>

                                                <input class="form-control qty" type="number" name="qty" id="qty" min="0"
                                                    value="{{ old('qty') }}" placeholder="Enter asset's quantity"
                                                    required>
                                                @if ($errors->has('qty'))
                                                    <span class="text-danger">{{ $errors->first('qty') }}</span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="unit_id">Unit<span class="text-danger">*</span></label>
                                                <select name="unit_id" id="unit_id" class="form-control" required>
                                                    <option value=''>Select unit</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}" @if($unit->id == old('unit_id')) selected @endif>{{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cat_id">Category<span class="text-danger">*</span></label>
                                                <select name="cat_id" id="cat_id" class="form-control" required>
                                                    <option value=''>Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @if($category->id == old('cat_id')) selected @endif>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="subcat_id">Subcategory<span class="text-danger">*</span></label>
                                                <select name="subcat_id" id="subcat_id" class="form-control" required>
                                                    <option value=''>Select subcategory</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="brand_id">Brand<span class="text-danger">*</span></label>
                                                <select name="brand_id" id="brand_id" class="form-control" required>
                                                    <option value=''>Select brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}" @if($brand->id == old('brand_id')) selected @endif>{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="9" class="form-control"></textarea>
                                                @if ($errors->has('description'))
                                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4 pl-3">
                                            <div class="row ">
                                                <div class="form-group w-100">
                                                    <label for="img">Image</label>
                                                    <input class="form-control" type="file" name="img" id="img"
                                                        value="{{ old('img') }}">
                                                    @if ($errors->has('img'))
                                                        <span class="text-danger">{{ $errors->first('img') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="form-group w-100">
                                                    <label for="warranty">Warranty</label>
                                                   <div class="input-group">
                                                    <input class="form-control" type="number"min="0" step="0.1" name="warranty" id="warranty" placeholder="Enter warranty year"
                                                    value="{{ old('warranty') }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Year</span>
                                                      </div>
                                                   </div>
                                                    @if ($errors->has('warranty'))
                                                        <span class="text-danger">{{ $errors->first('warranty') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="form-group w-100">
                                                    <label for="supplier_id">Supplier</label>
                                                    <select name="supplier_id" id="supplier_id">
                                                        <option value="">Select Supplier</option>
                                                        @foreach ($suppliers as $supplier )
                                                            <option value="{{$supplier->id}}">{{$supplier->shop_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('supplier_id'))
                                                        <span class="text-danger">{{ $errors->first('supplier_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Department name  --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-11 m-auto">
                                    <div class="form-group">
                                        <label for="department_id">Department<span class="text-danger">*</span></label>
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value=''>Select Department</option>
                                            <option value="">Common Asset</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" @if($department->id == old('department_id')) selected @endif>{{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @if ($errors->has('department_id'))
                                        <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Asset price details  --}}
                    <div class="card">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-11 m-auto">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_price">Total Price (BDT)<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control total-price" type="number" min="0" name="total_price"
                                                    id="total_price" value="{{ old('total_price') }}"
                                                    placeholder="Enter asset's total price" required>
                                                @if ($errors->has('total_price'))
                                                    <span class="text-danger">{{ $errors->first('total_price') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_unit_price">Price(per unit)(BDT)<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="per_unit_price"
                                                    id="per_unit_price" value="{{ old('per_unit_price') }}"
                                                    placeholder="Per unit price" readonly>
                                                @if ($errors->has('per_unit_price'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('per_unit_price') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary w-100">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/ckeditor/build/ckeditor.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function(){
            $('select').select2();
            ClassicEditor.create(document.querySelector('textarea'));
            // console.log("I am old value : {{ old('cat_id') }}");
            // console.log("I root value :" +$('#cat_id').val());

            //Subcategory fetch according to category id
            $('#cat_id').on('click change',function(){
                get_ajax.apply(this);
            });
            get_ajax.apply($('#cat_id'));


            //per unit price calculate from total price
            $('#total_price,#qty').on('click keyup change',function(){
                let total_price = Number($('#total_price').val());
                let qty = Number($('#qty').val());

                if(total_price>0 && qty>0){
                    let unt_price = Number.parseFloat(total_price/qty).toFixed(2);
                    $('#per_unit_price').val(unt_price);
                }else{

                }

            });

            let old_total_price = Number($('#total_price').val());
            let old_qty = Number($('#qty').val());

            if(old_total_price>0 && old_qty>0){
                let unt_price = Math.round(old_total_price/old_qty);
                $('#per_unit_price').val(unt_price);
            }
        });

        //funtion

        function get_ajax(){

            let cat_id = $(this).val();
            let subcat_id = '{{old('subcat_id')}}';
            if(cat_id){
                $.ajax({
                    type: "get",
                    url: '{{route("asset.product.subcat.fetch")}}',
                    data:{id : cat_id},
                    success:function(response){
                        let option = "<option value=''>Select subcategory</option>";
                        if(response){
                            $.each(response,function(index,item){
                                option += `<option value='${item.id}' ${item.id == subcat_id ? 'selected' : '' }>${item.name}</option>`;
                            });
                            $('#subcat_id').html(option);
                        }else{
                            $('#subcat_id').html(option);
                        }
                }
            });
            }

        }
    </script>
@endpush
