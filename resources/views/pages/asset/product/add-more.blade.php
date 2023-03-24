@extends('layouts.app')

@section('title', 'Asset Management - Add Asset')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-lg-12">
                {{-- Asset details  --}}
                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
                <div class="row">
                    <div class="col-md-3 mr-auto">
                        <span>Total info show</span>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <tbody>
                                            <tr>
                                                <th>Department</th>
                                                <td>{{ $product->department->department_name ?? 'Common Asset' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Category</th>
                                                <td>{{ $product->category->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Sub-category</th>
                                                <td>{{ $product->subcategory->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Brand</th>
                                                <td>{{ $product->brand->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Total Quantity</th>
                                                <td>{{ Number_format($product->qty) }}</td>
                                            </tr>

                                            <tr>
                                                <th>Unit</th>
                                                <td>{{ $product->unit->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Total Price</th>
                                                <td>BDT {{number_format($product->total_price, 2)}} </td>
                                            </tr>
                                            {{-- <tr>
                                                <th>asset Name</th>
                                                <td>{{ $asset->name }}</td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <span>Details</span>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Asset Name</th>
                                                <th>Quantity</th>
                                                <th>Warranty</th>
                                                <th>Total Price</th>
                                                <th>Supplier</th>
                                                <th>Stored at</th>
                                                <th>Stored by</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($more_products as $more_product)
                                                <tr>
                                                    <td>{{ $more_product->product->name }}</td>
                                                    <td>{{ Number_format($more_product->quantity) }}</td>
                                                    <td>{{ $more_product->warranty }}</td>
                                                    <td>BDT {{ number_format($more_product->total_price, 2) }} </td>
                                                    <td>{{ $more_product->supplier->shop_name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($more_product->created_at)) }}</td>
                                                    <td>{{ $more_product->created_user->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <form action="{{ route('asset.product.add.more.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-md-12">
                                <span class="float-left ml-2">
                                    <h4>Add more asset</h4>
                                </span>

                                <span class="float-right">
                                    @if (Auth::user()->can('asset view') || Auth::user()->role->id == 1)
                                        <a href="{{ route('asset.product.index') }}" class="btn btn-info">Back</a>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-11 m-auto justify-content-center">
                                    <div class="row">

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="qty">Quantity<span class="text-danger">*</span></label>
                                                <input class="form-control qty" type="number" name="qty" id="qty"
                                                    min="0" value="{{ old('qty') }}"
                                                    placeholder="Enter asset's quantity" required>
                                                @if ($errors->has('qty'))
                                                    <span class="text-danger">{{ $errors->first('qty') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="warranty">Warranty</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="number"min="0" step="0.1"
                                                        name="warranty" id="warranty" placeholder="Enter warranty year"
                                                        value="{{ old('warranty') }}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Year</span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('warranty'))
                                                    <span class="text-danger">{{ $errors->first('warranty') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="total_price">Total Price (BDT)<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control total-price" type="number" min="0"
                                                    name="total_price" id="total_price" value="{{ old('total_price') }}"
                                                    placeholder="Enter asset's total price" required>
                                                @if ($errors->has('total_price'))
                                                    <span class="text-danger">{{ $errors->first('total_price') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="per_unit_price">Price(per unit)(BDT)<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="per_unit_price"
                                                    id="per_unit_price" value="{{ old('per_unit_price') }}"
                                                    placeholder="Per unit price" readonly>
                                                @if ($errors->has('per_unit_price'))
                                                    <span class="text-danger">{{ $errors->first('per_unit_price') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="supplier_id">Supplier<span class="text-danger">*</span></label>
                                                <select name="supplier_id" class="form-control" id="supplier_id">
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->shop_name }}
                                                        </option>
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

                    <div class="col-md-12">
                        <button class="btn btn-primary w-100">Add</button>
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
        $(document).ready(function() {
            $('select').select2();
            ClassicEditor.create(document.querySelector('textarea'));
            // console.log("I am old value : {{ old('cat_id') }}");
            // console.log("I root value :" +$('#cat_id').val());

            //Subcategory fetch according to category id
            $('#cat_id').on('click change', function() {
                get_ajax.apply(this);
            });
            get_ajax.apply($('#cat_id'));


            //per unit price calculate from total price
            $('#total_price,#qty').on('click keyup change', function() {
                let total_price = Number($('#total_price').val());
                let qty = Number($('#qty').val());

                if (total_price > 0 && qty > 0) {
                    let unt_price = Number.parseFloat(total_price / qty).toFixed(2);
                    $('#per_unit_price').val(unt_price);
                } else {

                }

            });

            let old_total_price = Number($('#total_price').val());
            let old_qty = Number($('#qty').val());

            if (old_total_price > 0 && old_qty > 0) {
                let unt_price = Math.round(old_total_price / old_qty);
                $('#per_unit_price').val(unt_price);
            }
        });

        //funtion

        function get_ajax() {

            let cat_id = $(this).val();
            let subcat_id = '{{ old('subcat_id') }}';
            if (cat_id) {
                $.ajax({
                    type: "get",
                    url: '{{ route('asset.product.subcat.fetch') }}',
                    data: {
                        id: cat_id
                    },
                    success: function(response) {
                        let option = "<option value=''>Select subcategory</option>";
                        if (response) {
                            $.each(response, function(index, item) {
                                option +=
                                    `<option value='${item.id}' ${item.id == subcat_id ? 'selected' : '' }>${item.name}</option>`;
                            });
                            $('#subcat_id').html(option);
                        } else {
                            $('#subcat_id').html(option);
                        }
                    }
                });
            }

        }
    </script>
@endpush
