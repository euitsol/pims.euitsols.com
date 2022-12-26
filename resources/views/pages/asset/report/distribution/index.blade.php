@extends('layouts.app')

@section('title', 'Distribution Products Report')

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

                        @if($errors)
                        {{-- @dd($errors) --}}
                            <ul>
                                @foreach($errors as $error)
                                    <li>
                                        @dd($error)
                                        {{$error}}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control" id="department_id">
                                            <option value="">Common asset</option>
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
                    </div>
                </div>


                 {{-- Report show --}}
                    <div id="report_show">

                    </div>
                    <div class="card p-5" id="loading_card" style="display: none">
                        <div class="spinner-border text-primary m-auto" style="width: 3rem; height: 3rem;" role="status"></div>
                    </div>



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
        $('#report_show').hide();

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
                if(department_id){
                    if(!section_id){
                    toastr.error('Please, select section');
                    return false;
                    }
                    if(!subsection_id){
                        toastr.error('Please, select subsection');
                        return false;
                    }
                }
                $('#info_card').hide('slow');
                $('#show_card').hide(200);
                $('#loading_card').show(200);

                ajaxDataFetch('AssignProduct',{'department_id':department_id,'section_id':section_id,'subsection_id':subsection_id},['mainProduct','mainProduct.product','mainProduct.category','mainProduct.subcategory','mainProduct.supplier','department'],function(response){

                    let append = '';
                  $.each(response,function(index,item){
                     append += `<div class='card'>
                                    <div class='card-header'>
                                        <h4>${item.department.department_name}</h4>
                                    </div>
                                `;
                        append += ` <div class='card-body'>
                                        <table class='table table-striped'>
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                    $.each(item.main_product,function(index2,main_assign_product){
                                        append += `<tr>
                                                        <td>${main_assign_product.product.name}</td>
                                                        <td>${main_assign_product.product.qty}</td>
                                                        <td>${main_assign_product.product.total_price}</td>
                                                    </tr>`;
                    });
                                append += `</tbody>
                                        </table>
                                    </div>
                                </div>`;
                  });
                  $('#report_show').html(append);
                  $('#loading_card').fadeOut(300,function(){

                      $('#report_show').fadeIn(300);
                  });

                });
            });
    });

    </script>
@endpush
