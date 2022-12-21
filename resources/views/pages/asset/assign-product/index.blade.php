@extends('layouts.app')

@section('title', 'Assign Product Management')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Assign Product</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="">
                            @csrf
                            <input type="hidden" name="semester_id" value="">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control" id="department_id">
                                            <option value="">All Department</option>
                                            @foreach ($departments as $n)
                                                <option value="{{ $n->id }}"
                                                    @if (old('department_id') == $n->id) selected @endif>
                                                    {{ $n->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                            <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section_id">Section</label>
                                        <select name="section_id" class="form-control" id="section_id">
                                            <option value="" hidden>Select Section</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    @if (old('section_id') == $section->id) selected @endif>
                                                    {{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('section_id'))
                                            <span class="text-danger">{{ $errors->first('section_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subsection_id">Sub-section</label>
                                        <select name="subsection_id" class="form-control" id="subsection_id">
                                            <option value="" hidden>Select Sub-section</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    @if (old('subsection_id') == $section->id) selected @endif>
                                                    {{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('subsection_id'))
                                            <span class="text-danger">{{ $errors->first('subsection_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_id">Product</label>
                                        <select name="product_id" class="form-control select" id="product_id" required>
                                            <option value="" hidden>Select Product</option>
                                        </select>
                                        @if ($errors->has('product_id'))
                                            <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- //assign product search --}}
                    <div class="card book-select-card">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Assign Book</h4>
                            </span>
                        </div>
                        <div class="card-body position-relative">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Sub-category</th>
                                            <th>Product</th>
                                            <th>Supplier</th>
                                            <th>Available Product</th>
                                            <th>Quantity</th>
                                            <th class="text-left">
                                                <span class="btn btn-info plus-btn" id="0">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        <tr>
                                            <td>
                                                <select class="form-control cat-id0" required tabindex="-1" id="cat_id">
                                                    <option value="" hidden>Select category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-control department_id0 select" tabindex="-1"
                                                    id="subcat_id">
                                                    <option value="">Select SubCategory</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="book[0][book_id]"class="form-control book-id book-id0"
                                                    required tabindex="-1" id="product_id">
                                                    <option value="" hidden>Select Product</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="book[0][book_id]" class="form-control book-id book-id0"
                                                    required tabindex="-1" id="supplier_id">
                                                    <option value="" hidden>Select Suppelier</option>
                                                </select>
                                            </td>
                                            <td class="available-qty">
                                                <input type="number" class="form-control text-center" id="available_qty" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="book[0][qty]"
                                                    class="form-control qty0 text-center" min="1" max=""
                                                    value="1" placeholder="Enter quantity" id="qty">
                                                <span></span>
                                            </td>
                                            <td class="text-left" id="plus_minus_btn">
                                                <span class="btn btn-sm btn-danger minus-btn0">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                            <button type="button" class="btn btn-info w-100 mt-4" id="assign_btn">Assign</button>
                        </div>
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
        $(document).ready(function() {
            $('select').select2();

            //Section fetch according to Department
            $("#department_id").change(function() {
                ajaxDataFetch(['department_id'],'Section', "section_id", ['created_user', 'updated_user',
                    'deleted_user', 'department'
                ]);
            });
            ajaxDataFetch(['department_id'], 'Section', "section_id", ['created_user', 'updated_user', 'deleted_user',
                'department'
            ], "{{ old('section_id') }}");
            //End Section fetch according to Department


            //Sub-section fetch according to Section
            $("#section_id").change(function() {
                ajaxDataFetch(['section_id'], 'Subsection', "subsection_id", ['created_user', 'updated_user',
                    'deleted_user', 'section'
                ]);
            });
            ajaxDataFetch(['section_id'], 'Subsection', "subsection_id", ['created_user', 'updated_user',
                'deleted_user', 'section'
            ], "{{ old('subsection_id') }}");
            //End Sub-section fetch according to Section



            //Sub-category fetch according to Category
            $("#cat_id").change(function() {
                ajaxDataFetch(['cat_id'], 'Subcategory', "subcat_id", ['created_user', 'updated_user',
                    'deleted_user', 'category'
                ]);
            });



            //product fetch according to sub-category
            $("#subcat_id").change(function() {
                ajaxDataFetch(['subcat_id'], 'Product', "product_id", ['created_user', 'updated_user','deleted_user', 'subcategory']);
            });

            //Supplier fetch according to Product
            $("#product_id").change(function(element) {
                console.log($(this));
                ajaxDataFetch(['product_id'],'MoreProduct', "supplier_id", ['created_user', 'updated_user',
                    'deleted_user', 'supplier'
                ],function(response){
                    let count = 0;
                    $.each(response,function(key,item){
                        count += Number(item.quantity);
                    })
                    $('#available_qty').val(count)
                },null,null,'supplier',null,'shop_name');
            });
        });


        //Ajax Data fetch according to  department
        function ajaxDataFetch(collect_data_arr, model, append_element, with_arr,returnFunc=null, stop, old_value = null, belongs_to, has_many = null, coloum='name') {
            let data_arr = {};
            for (selector in collect_data_arr) {
                data_arr[collect_data_arr[selector]] = $('#' + collect_data_arr[selector]).val();
            }
            $.ajax({
                url: "{{ route('asset.product_fetch.ajax') }}",
                method: 'GET',
                async: false,
                data: {
                    'arr': data_arr,
                    'model': model,
                    'with_arr': with_arr,
                },
                success: function(response) {
                    var option = "<option value='' hidden>Select...</option>";
                   if(returnFunc){
                    returnFunc(response)
                   }
                   if(stop != 'stop'){
                        $.each(response, function(index, value) {
                            if (value[has_many]) {
                                $.each(value[has_many], function(has_index, has_value) {
                                    if (has_value[belongs_to]) {
                                        option += `<option value="${has_value[belongs_to].id}" ${old_value == has_value[belongs_to].id ? 'selected' : ''}>${has_value[belongs_to][coloum]}</option>`;
                                    } else {
                                        option += `<option value="${has_value.id}" ${old_value == has_value.id ? 'selected' : ''}>${has_value[coloum]}</option>`;
                                    }
                                });
                            }
                            else if(value[belongs_to]){
                                if(value[belongs_to][has_many]){
                                    console.log()
                                    $.each(value[belongs_to][has_many], function(belongs_index,belongs_value) {
                                        option += `<option value="${belongs_value.id}" ${old_value == belongs_value.id ? 'selected' : ''}>${belongs_value[coloum]}</option>`;
                                    });
                                } else {
                                        option += `<option value="${value[belongs_to].id}" ${old_value == value[belongs_to].id ? 'selected' : ''}>${value[belongs_to][coloum]}</option>`;
                                    }
                            }
                            else {
                                option += `<option value="${value.id}" ${old_value == value.id ? 'selected' : ''}>${value[coloum]}</option>`;
                            }
                        });
                        $('#' + append_element).html(option);
                    }
                }
            });
        }
    </script>
@endpush
