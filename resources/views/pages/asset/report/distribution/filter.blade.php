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
                <form action="{{route('asset.report.distribution.fetch')}}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Assign Asset</h4>
                            </span>
                        </div>
                        <div class="card-body">

                            @if ($errors)

                                <ul>
                                    @foreach ($errors as $error)
                                        <li>
                                            @dd($error)
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control" id="department_id">
                                            <option value="all">All</option>
                                            <option value=""
                                                @if (isset($department_id)) @if ($department_id == 'common_asset') selected @endif
                                                @endif >Common Asset</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if (isset($department_id)) @if ($department_id == $department->id) selected @endif
                                                    @endif >
                                                    {{ $department->department_name }}</option>
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
                            <div class="row mt-3">
                                <div class="col-md-1 offset-md-2">
                                    <label for="date">Date range<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6 text-left ">
                                    <div class="input-group">
                                        <input name="str_date" type="date" id="str_date" class="form-control date"
                                            value="">
                                        <span class="input-group-text">to</span>
                                        <input name="end_date" type="date" id="end_date" class="form-control date"
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4 search">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


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
    <script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        //hide
        $('#report_show').hide();
        $(document).ready(function() {
            $('select').select2();

            function dataTabl() {
                $('#info_card table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'pdfHtml5',
                        title: 'Distribution report',
                        download: 'open',
                        orientation: 'potrait',
                        pagesize: 'LETTER',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }, {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }, 'pageLength']
                });
            }
            //Section fetch according to Department
            $("#department_id").change(function() {
                $('#subsection_id').html("<option value='' selected> Select... </option>");
                let department_id = $(this).val();
                ajaxDataFetch('Section', {
                    'department_id': department_id
                }, ['created_user', 'updated_user',
                    'deleted_user', 'department'
                ], null, $('#section_id'));
            });

            //Sub-section fetch according to Section
            $("#section_id").change(function() {
                let section_id = $(this).val();
                ajaxDataFetch('Subsection', {
                    'section_id': section_id
                }, ['created_user', 'updated_user',
                    'deleted_user', 'section'
                ], null, $("#subsection_id"));
            });

            //search button click
            $('.search').on('click', function() {
                let department_id = $('#department_id').val();
                let section_id = $('#section_id').val();
                let subsection_id = $('#subsection_id').val();
                let date1 = $('#str_date').val();
                let date2 = $('#end_date').val();
                var data_boj = {
                    'department_id': department_id,
                };

               if(section_id){
                data_boj.section_id =section_id;
               }

               if(subsection_id){
                data_boj.subsection_id =subsection_id;
               }

               if(date1){
                data_boj.date1 =date1
               }

               if(date2){
                data_boj.date2 =date2
               }
            //    console.log(data_boj);

                $('#info_card').hide('slow');
                $('#show_card').hide(200);
                $('#loading_card').show(200);
                $.ajax({
                    method: 'get',
                    url: '{{ route('asset.report.distribution.fetch') }}',
                    data: data_boj,
                    success: function(response) {

                        let append

                        $.each(response, function(index,item) {
                             append += `<div class='card'>
                                        <div class='card-header'>
                                            <h4></h4>
                                        </div>
                                    `;
                                    append += ` <div class='card-body'>
                                            <table class='table table-striped'>
                                                <thead>
                                                    <tr>
                                                        <th>Department Name</th>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                            $.each(item.main_product, function(index,main_assing) {
                                append += `<tr>
                                                <td>${main_assing.product.department ? main_assing.product.department.department_name : 'Common Asset'}</td>
                                                <td>${main_assing.product.name}</td>
                                                <td>${main_assing.product.qty}</td>
                                                <td>${main_assing.created_user.name}</td>
                                            </tr>`;
                            })
                            append += `</tbody>
                                            </table>
                                        </div>
                                    </div>`;
                        });

                        $('#report_show').html(append);
                        $('#loading_card').fadeOut(300, function() {
                            $('#report_show').fadeIn(300);
                        });
                    }
                })
                // ajaxDataFetch('AssignProduct', {
                //     'department_id': department_id,
                //     'section_id': section_id,
                //     'subsection_id': subsection_id
                //     }, ['mainProduct', 'mainProduct.product','mainProduct.product.department', 'mainProduct.category',
                //         'mainProduct.subcategory', 'mainProduct.supplier', 'department'
                //     ], function(response) {

                //         let append = '';
                //         $.each(response, function(index, item) {
                //             append += `<div class='card'>
            //                         <div class='card-header'>
            //                             <h4>${item.department.department_name}</h4>
            //                         </div>
            //                     `;
                //             append += ` <div class='card-body'>
            //                             <table class='table table-striped'>
            //                                 <thead>
            //                                     <tr>
            //                                         <th>Department Name</th>
            //                                         <th>Product Name</th>
            //                                         <th>Quantity</th>
            //                                         <th>Created By</th>
            //                                     </tr>
            //                                 </thead>
            //                                 <tbody>`;

                //             $.each(item.main_product, function(index2, main_assign_product) {
                //                 console.log(main_assign_product)
                //                 append += `<tr>
            //                                             <td>${main_assign_product.product.department.department_name}</td>
            //                                             <td>${main_assign_product.category.name}</td>
            //                                             <td>${main_assign_product.product.name}</td>
            //                                             <td>${main_assign_product.product.qty}</td>
            //                                             <td>${main_assign_product.created_by.name}</td>
            //                                         </tr>`;
                //             });
                //             append += `</tbody>
            //                             </table>
            //                         </div>
            //                     </div>`;
                //         });
                //         $('#report_show').html(append);
                //         $('#loading_card').fadeOut(300, function() {
                //             $('#report_show').fadeIn(300);
                //         });

                // });
            });
        });
    </script>
@endpush
