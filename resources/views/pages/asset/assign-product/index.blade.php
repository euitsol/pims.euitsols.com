@extends('layouts.app')

@section('title', 'Assign Asset Management')

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
                            <h4>Assign Asset</h4>
                        </span>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control" id="department_id">
                                            <option value="">Select Department</option>
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
                    </div>
                </div>

                {{-- Previous info  --}}
                <div class="card" id="info_card">
                    <div class="card-header">
                        <h3 class="text-header">Previous Assigned Assets</h3>
                    </div>
                    <div class="body">
                        <div class="table-response px-4">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Sub-category</th>
                                        <th>Asset</th>
                                        <th>Supplier</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="info_body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                 {{-- assign Asset search --}}
                 <form action="{{route('asset.assign.product.main_assign')}}" method="POST">
                    @csrf
                    <div class="card" id="show_card">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Asset Selection</h4>
                            </span>
                        </div>
                        <div class="card-body position-relative">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Sub-category</th>
                                            <th>Asset</th>
                                            <th>Supplier</th>
                                            <th>Available Asset</th>
                                            <th>Quantity</th>
                                            <th class="text-left">
                                                <span class="btn btn-info plus-btn" id="1">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                   <form action="">
                                    <tbody id="tbody">

                                    </tbody>
                                   </form>
                                </table>
                                <button class="btn btn-info w-100 mt-4" id="assign_btn">Assign</button>
                            </div>
                        </div>
                    </div>
                    <div class="card p-5" id="loading_card" style="display: none">
                        <div class="spinner-border text-primary m-auto" style="width: 3rem; height: 3rem;" role="status"></div>
                    </div>
                </form>


            </div>
        </div>
    </div>

@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="{{asset('assets/js/DataTable/datatables.min.js')}}"></script>
@endpush

@push('page_scripts')
    <script>
        //hide
        $('#assign_btn').hide();
        $('.plus-btn').hide();
        $('#info_card').hide();

        $(document).ready(function() {
            $('select').select2();
           function dataTabl(){
            $('#info_card table').DataTable({
            dom: 'Bfrtip'
            , buttons: [{
                        extend: 'pdfHtml5'
                        , title: 'Previous Assigned Asset'
                        , download: 'open'
                        , orientation: 'potrait'
                        , pagesize: 'LETTER'
                        , exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                    , {
                        extend: 'print'
                        , exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }, 'pageLength'
                ]
            });
           }
            //Section fetch according to Department
            $("#department_id").change(function() {
                $('#subsection_id').html("<option value='' selected> Select... </option>");
                let department_id = $(this).val();
                ajaxDataFetch('Section',{'department_id':department_id}, ['created_user', 'updated_user',
                    'deleted_user', 'department'
                ],null,$('#section_id'));
            });

            //Sub-section fetch according to Section
            $("#section_id").change(function() {
                let section_id = $(this).val();
                ajaxDataFetch('Subsection',{'section_id':section_id}, ['created_user', 'updated_user',
                    'deleted_user', 'section'
                ],null, $("#subsection_id"));
            });

            //search button click
            $('.search').on('click',function(){
                let department_id = $('#department_id').val();
                let section_id = $('#section_id').val();
                let subsection_id = $('#subsection_id').val();
                if(!department_id){
                    toastr.error('Please, Select Department');
                    return false;
                }
                if(!section_id){
                toastr.error('Please, Select Section');
                return false;
                }

                if(!subsection_id){
                    toastr.error('Please, Select Subsection');
                    return false;
                }

                $('#info_card').hide('slow');
                $('#show_card').hide(200);
                $('#loading_card').show(200);

                ajaxDataFetch('AssignProduct',{'department_id':department_id,'section_id':section_id,'subsection_id':subsection_id},['mainProduct','mainProduct.product','mainProduct.product.category','mainProduct.product.subcategory','mainProduct.supplier'],function(response){
                setTimeout(() => {

                    if(response && JSON.stringify(response).length>2){
                            $.each(response,function(index,item){
                                 let append =`
                                        <input type='hidden' name='assign_product_id' value='${item.id}'>
                                        <input type='hidden' name='department_id' value='${item.department_id}'>
                                        <input type='hidden' name='section_id' value='${item.section_id}'>
                                        <input type='hidden' name='subsection_id' value='${item.subsection_id}'>
                                        `;
                                if(item.main_product.length != 0){
                                    let info_body = ``;
                                    $.each(item.main_product,function (index,item) {
                                        console.log(item)
                                        info_body +=`
                                                <tr>
                                                    <td>${item.product.category.name}</td>
                                                    <td>${item.product.subcategory.name}</td>
                                                    <td>${item.product.name}</td>
                                                    <td>${item.supplier.shop_name}</td>
                                                    <td>${ Number((item.qty).toFixed(1)).toLocaleString(1)}</td>
                                                </tr>
                                                `;
                                     });
                                    $('#info_body').html(info_body);
                                    $('#info_card').show(200);
                                }
                                    append +=`
                                        <tr>
                                            <td>
                                                <select name="product[${index}][cat_id]" class="form-control cat-id" required tabindex="-1">
                                                    <option value="" hidden>Select category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="product[${index}][subcat_id]" class="form-control subcat-id" tabindex="-1">
                                                    <option value="">Select SubCategory</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="product[${index}][product_id]" class="form-control product-id"
                                                    required tabindex="-1">
                                                    <option value="" hidden>Select Asset</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="product[${index}][supplier_id]" class="form-control supplier-id"
                                                    required tabindex="-1">
                                                    <option value="" hidden>Select Suppelier</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control text-center available-qty" readonly>
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

                                $('#tbody').html(append);
                                $('#show_card').show(200);
                                $('#loading_card').hide(200);
                                $('#assign_btn').show(200);
                                $('.plus-btn').show(200);
                                $('select').select2();
                            });



                    }else{
                        $.ajax({
                            method:'get',
                            url: "{{route('asset.assign.product.store')}}",
                            data:{
                                'department_id':department_id,
                                'section_id':section_id,
                                'subsection_id':subsection_id,
                            },
                            success:function(response){
                                console.log(response);
                                let append = ` <input type='hidden' name='assign_product_id' value='${response}'>
                                        <tr>
                                            <td>
                                                <select name="product[0][cat_id]" class="form-control cat-id" required tabindex="-1">
                                                    <option value="" hidden>Select category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="product[0][subcat_id]" class="form-control subcat-id" tabindex="-1">
                                                    <option value="">Select SubCategory</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="product[0][product_id]" class="form-control product-id"
                                                    required tabindex="-1">
                                                    <option value="" hidden>Select Asset</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="product[0][supplier_id]" class="form-control supplier-id"
                                                    required tabindex="-1" id="supplier_id">
                                                    <option value="" hidden>Select Suppelier</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control text-center available-qty" readonly>
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
                                $('#assign_btn').show();
                                $('.plus-btn').show();
                                $('select').select2();
                            }
                        });
                    }
                },200)
                });
            });


            //Sub-category fetch according to Category
            catFetch(".cat-id",".subcat-id");
            function catFetch(selector,appender){
                    $(document).on('change',selector,function(){
                        let index = $(this).index(selector);
                        let append_selector = $(appender).eq(index);
                        let cat_id = $(this).val();
                    ajaxDataFetch('Subcategory',{selector},  ['created_user', 'updated_user',
                        'deleted_user', 'category'
                    ],null,append_selector);
                });
            }

            //Asset fetch according to sub-category
            subcatFetch(".subcat-id",".product-id");
            function subcatFetch(selector,appender){
                $(document).on('change',selector,function(){
                    let subcat_id  = $(this).val();
                    let index = $(this).index(selector);
                    let append_selector = $(appender).eq(index);
                    // ,'department_id':$('#department_id').val()
                    ajaxDataFetch('Product',{'subcat_id':subcat_id},  ['created_user', 'updated_user', 'deleted_user', 'subcategory'],null,append_selector,null,null,null,'name',{orWhere:{department_id:null}});
                });
            }


        //Supplier fetch according to Asset
           productFetch(".product-id",".supplier-id",'.available-qty');
           function productFetch(selector,appender,qty)
           {
            $(document).on('change',selector,function(){
                    let product_id  = $(this).val();
                    let existing_check = 0;
                    $('.product-id').each(function(){
                        if($(this).val() == product_id){
                            existing_check++;
                        }
                    });
                    if(existing_check>1){
                        toastr.error('You have already selected this asset');
                        return false
                    }
                    let index = $(this).index(selector);
                    let append_selector = $(appender).eq(index);
                    let available_qty = $(qty).eq(index);

                    ajaxDataFetch('MoreProduct',{'product_id':product_id}, ['created_user', 'updated_user','deleted_user', 'supplier','product'],
                    function(response){
                        let count = 0;
                        $.each(response,function(key,item){
                            count = Number(item.product.qty);
                        })
                        $(available_qty).val(count-1);
                        $(available_qty).attr('data-id',count);
                    },append_selector,null,'supplier',null,'shop_name');
                });
           }

        //append element (plus button)
        $('.plus-btn').on('click',function(){
            appendElement(this)
        });
        //remove button
        remove('.minus-btn');


        function appendElement(click_element,target_elemnent)
        {
            let tr_count = $('#tbody').find('tr').length;
               if(tr_count > 9){
                toastr.error("You can't add more then five");
               }else{
                let count = $(click_element).prop('id');
                let append_element = `
                                    <tr>
                                        <td>
                                            <select name="product[${count}][cat_id]" class="form-control cat-id" required tabindex="-1">
                                                <option value="" hidden>Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select  name="product[${count}][subcat_id]" class="form-control subcat-id" tabindex="-1"
                                                id="subcat_id-${count}">
                                                <option value="">Select SubCategory</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select  name="product[${count}][product_id]" class="form-control product-id"
                                                required tabindex="-1" id="product_id-${count}">
                                                <option value="" hidden>Select Asset</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select  name="product[${count}][supplier_id]" class="form-control supplier-id"
                                                required tabindex="-1" id="supplier_id-${count}">
                                                <option value="" hidden>Select Suppelier</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-center available-qty" readonly>
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

        //remove function
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

        //available asset count
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
