@extends('layouts.app')

@section('title', 'Asset Management - Add Product')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">



            <div class="col-md-10 col-lg-12">
                <form action="{{ route('asset.product.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    {{-- Product details  --}}
                    <div class="row">
                        <div class="col-md-3 mr-auto">
                            <span>Total info show</span>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm">

                                            <tbody>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <td>{{ $product->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <td>{{ $product->qty }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Unit</th>
                                                    <td>{{ $product->unit->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Price</th>
                                                    <td>{{ $product->total_price }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Brand</th>
                                                    <td>{{ $product->brand->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td>{{ $product->category->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <td>{{ $product->department->department_name ?? 'All Department' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">

                        </div>

                    </div>

                    <form action="">
                        @csrf
                        <div class="row w-100 mb-2">
                            <div class="col-md-12">
                                <span class="float-left ml-2">
                                    <h4>Add more product</h4>
                                </span>

                                <span class="float-right">
                                    @if (Auth::user()->can('product view') || Auth::user()->role->id == 1)
                                        <a href="{{ route('asset.product.index') }}" class="btn btn-info">Back</a>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-11 m-auto justify-content-center">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="qty">Quantity<span class="text-danger">*</span></label>
                                                    <input class="form-control qty" type="number" name="qty"
                                                        id="qty" min="0" value="{{ old('qty') }}"
                                                        placeholder="Enter product's quantity" required>
                                                    @if ($errors->has('qty'))
                                                        <span class="text-danger">{{ $errors->first('qty') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="warranty">Warranty</label>
                                                    <input class="form-control" type="number"min="0" step="0.1"
                                                        name="warranty" id="warranty" placeholder="Enter warranty year"
                                                        value="{{ old('warranty') }}">
                                                    @if ($errors->has('warranty'))
                                                        <span class="text-danger">{{ $errors->first('warranty') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="total_price">Total Price<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control total-price" type="number" min="0"
                                                        name="total_price" id="total_price"
                                                        value="{{ old('total_price') }}"
                                                        placeholder="Enter product's total price" required>
                                                    @if ($errors->has('total_price'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('total_price') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="per_unit_price">Price(per unit)<span
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

                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="supplier">Supplier<span class="text-danger">*</span></label>
                                                    <select name="supplier" class="form-control" id="supplier">
                                                        <option value="">Select Supplier</option>
                                                    </select>
                                                    @if ($errors->has('supplier'))
                                                        <span class="text-danger">{{ $errors->first('supplier') }}</span>
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
