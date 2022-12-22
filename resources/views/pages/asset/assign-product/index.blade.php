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
                        {{-- <form action="{{route('asset.assign.product.store')}}" method="POST">
                            @csrf --}}
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

                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4 search">Search</button>
                                </div>
                            </div>
                        {{-- </form> --}}
                    </div>

                    {{-- assign product search --}}
                    <form action="{{route('asset.assign.product.assign_more')}}" method="POST">
                        <div class="card" id="show_card">
                            <div class="card-header">
                                <span class="float-left">
                                    <h4>Product Selection</h4>
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
                                                    <select name="product[0][cat_id]" class="form-control" required tabindex="-1" id="cat_id">
                                                        <option value="" hidden>Select category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td>
                                                    <select name="product[0][subcat_id]" class="form-control" tabindex="-1"
                                                        id="subcat_id">
                                                        <option value="">Select SubCategory</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <select name="product[0][product_id]" class="form-control"
                                                        required tabindex="-1" id="product_id">
                                                        <option value="" hidden>Select Product</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <select name="product[0][supplier_id]" class="form-control"
                                                        required tabindex="-1" id="supplier_id">
                                                        <option value="" hidden>Select Suppelier</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center available-qty" id="available_qty" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="product[0][qty]"
                                                        class="form-control qty text-center" min="1" max=""
                                                        value="1" placeholder="Enter quantity">
                                                    <span></span>
                                                </td>
                                                <td class="text-left minus-btn" >
                                                    <span class="btn btn-sm btn-danger">
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
                        <div class="card p-5" id="loading_card" style="display: none">
                            <div class="spinner-border text-primary m-auto" style="width: 3rem; height: 3rem;" role="status"></div>
                        </div>
                    </form>
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

            $('.search').on('click',function(){
                $('#show_card').hide();
                $('#loading_card').show();
                ajaxDataFetch(['department_id'],'Product',['created_user', 'updated_user',
                    'deleted_user', 'department'
                ],function(response){
                    if(response && response.length>0){
                        console.dir(response);
                        setTimeout(() => {
                            let append ='';
                        $.each(response,function(index,item){
                            append +=`
                                    <tr>
                                        <td>
                                            <select name="product[${index}][cat_id]" class="form-control" required tabindex="-1" id="cat_id-${index}">
                                                <option value="" hidden>Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select name="product[${index}][subcat_id]" class="form-control" tabindex="-1"
                                                id="subcat_id-${index}">
                                                <option value="">Select SubCategory</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="product[${index}][product_id]" class="form-control"
                                                required tabindex="-1" id="product_id-${index}">
                                                <option value="" hidden>Select Product</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="product[${index}][supplier_id]" class="form-control"
                                                required tabindex="-1" id="supplier_id-${index}">
                                                <option value="" hidden>Select Suppelier</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-center available-qty" id="available_qty-${index}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="product[${index}][qty]"
                                                class="form-control qty text-center" min="1" max=""
                                                value="1" placeholder="Enter quantity">
                                            <span></span>
                                        </td>
                                        <td class="text-left minus-btn">
                                            <span class="btn btn-sm btn-danger">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        </td>
                                    </tr>`;
                        });

                        $('#tbody').html(append);
                        $('#show_card').show();
                        $('#loading_card').hide();
                        }, 300);
                    }else{
                        setTimeout(()=>{
                            let append = `
                                    <tr>
                                        <td>
                                            <select name="product[0][cat_id]" class="form-control" required tabindex="-1" id="cat_id">
                                                <option value="" hidden>Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select name="product[0][subcat_id]" class="form-control" tabindex="-1"
                                                id="subcat_id">
                                                <option value="">Select SubCategory</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="product[0][product_id]" class="form-control"
                                                required tabindex="-1" id="product_id">
                                                <option value="" hidden>Select Product</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="product[0][supplier_id]" class="form-control"
                                                required tabindex="-1" id="supplier_id">
                                                <option value="" hidden>Select Suppelier</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-center available-qty" id="available_qty" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="product[0][qty]"
                                                class="form-control qty text-center" min="1" max=""
                                                value="1" placeholder="Enter quantity">
                                            <span></span>
                                        </td>
                                        <td class="text-left minus-btn">
                                            <span class="btn btn-sm btn-danger">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        </td>
                                    </tr>`;
                        $('#tbody').html(append);
                        $('#show_card').show();
                        $('#loading_card').hide();
                        },300)
                    }
                });
            });
            //Section fetch according to Department
            $("#department_id").change(function() {
                ajaxDataFetch(['department_id'],'Section', ['created_user', 'updated_user',
                    'deleted_user', 'department'
                ],null,'section_id');
            });
            ajaxDataFetch(['department_id'],'Section', ['created_user', 'updated_user',
                    'deleted_user', 'department'
                ],null,'section_id');
            //End Section fetch according to Department


            //Sub-section fetch according to Section
            $("#section_id").change(function() {
                ajaxDataFetch(['section_id'], 'Subsection', ['created_user', 'updated_user',
                    'deleted_user', 'section'
                ],null, "subsection_id");
            });
            $("#section_id").change(function() {
                ajaxDataFetch(['section_id'], 'Subsection', ['created_user', 'updated_user',
                    'deleted_user', 'section'
                ],null, "subsection_id");
            });
            //End Sub-section fetch according to Section



            //Sub-category fetch according to Category
            catFetch("cat_id","subcat_id");
            function catFetch(selector,appender){
                $('#'+selector).change(function() {
                    ajaxDataFetch([selector], 'Subcategory', ['created_user', 'updated_user',
                        'deleted_user', 'category'
                    ],null,appender);
                });
            }

            //product fetch according to sub-category
            subcatFetch("subcat_id","product_id");
            function subcatFetch(selector,appender){
                $('#'+selector).change(function() {
                    ajaxDataFetch([selector], 'Product', ['created_user', 'updated_user', 'deleted_user', 'subcategory'],null,appender);
                });
            }


            //Supplier fetch according to Product
           productFetch("product_id","supplier_id",'available_qty');
           function productFetch(selector,appender,qty)
           {
                $('#'+selector).change(function(element) {
                    ajaxDataFetch([selector],'MoreProduct', ['created_user', 'updated_user',
                        'deleted_user', 'supplier'
                    ],function(response){
                        let count = 0;
                        $.each(response,function(key,item){
                            count += Number(item.quantity);
                        })
                        $('#'+qty).val(count);
                        $('#'+qty).attr('data-id',count);
                    },appender,null,'supplier',null,'shop_name');
                });
           }
        $('.plus-btn').on('click',function(){
            appendElement(this)
        });
        //remove button
        remove('.minus-btn');
        function appendElement(click_element,target_elemnent)
        {
            let tr_count = $('#tbody').find('tr').length;
               if(tr_count > 4){
                toastr.error("You can't add more then five");
               }else{


                let count = $(click_element).prop('id');
                let append_element = `
                                    <tr>
                                        <td>
                                            <select name="product[${count}][cat_id]" class="form-control " required tabindex="-1" id="cat_id-${count}">
                                                <option value="" hidden>Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select  name="product[${count}][subcat_id]" class="form-control" tabindex="-1"
                                                id="subcat_id-${count}">
                                                <option value="">Select SubCategory</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select  name="product[${count}][product_id]" class="form-control"
                                                required tabindex="-1" id="product_id-${count}">
                                                <option value="" hidden>Select Product</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select  name="product[${count}][supplier_id]" class="form-control"
                                                required tabindex="-1" id="supplier_id-${count}">
                                                <option value="" hidden>Select Suppelier</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-center available-qty" id="available_qty-${count}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="product[${count}][qty]"
                                                class="form-control qty text-center" min="1" max=""
                                                value="1" placeholder="Enter quantity">
                                            <span></span>
                                        </td>
                                        <td class="text-left minus-btn">
                                            <span class="btn btn-sm btn-danger">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        </td>
                                    </tr>`;

                $('#tbody').append(append_element);
                $(click_element).attr('id',Number(count)+1);
                $('select').select2();
                catFetch('cat_id-'+count,'subcat_id-'+count);
                subcatFetch("subcat_id-"+count,"product_id-"+count);
                productFetch("product_id-"+count,"supplier_id-"+count,'available_qty-'+count);
            }
        }

        function remove(click_element){
            $(document).on('click',click_element,function(){
                let tr_count = $('#tbody').find('tr').length;
               if(tr_count < 2){
                toastr.error('Please, keep one');
               }else{
                   $(this).parent().remove();
               }
            });
        }
        //available product count
        $(document).on('keyup change','.qty',function(){
            let index = $(this).index('.qty');
            let qty = Number($(this).val());
            let available_qty_element  = $(`.available-qty:eq(${index})`);
            let available_qty = Number(available_qty_element.data('id'));
            $(this).attr('max',available_qty);
            available_qty = available_qty-qty;
            $(this).next('span').remove();
            if(available_qty<0){
                $(this).after("<span class='text-danger'>You can't add more than available quantity</span>");
            }

             $(`.available-qty:eq(${index})`).val(available_qty)

        });
    });

    </script>
@endpush
