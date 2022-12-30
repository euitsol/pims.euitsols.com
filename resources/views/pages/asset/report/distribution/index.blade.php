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
                <h4 class="text-center mb-4">Distribution Report</h4>

                @forelse($assign_products as $key => $assign_product)

                @if (count($assign_product->mainProduct))
                <div class="card">
                    <div class="card-header">
                        <h4>
                            {{$assign_product->department ? "Department of ".$assign_product->department->department_name : 'Common Asset'}}
                           {{$assign_product->section ? ", Section: ".$assign_product->section->name : ''}}
                           {{$assign_product->subsection ? ", Subsection: ".$assign_product->subsection->name : ''}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Category</th>
                                        <th>Sub-category</th>
                                        <th>Created At</th>
                                        <th>created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assign_product->mainProduct as $p)

                                        <tr>
                                            <td>{{$p->product->name}}</td>
                                            <td>{{$p->qty}}</td>
                                            <td>{{$p->product->category->name}}</td>
                                            <td>{{$p->product->subcategory->name}}</td>
                                            <td>{{date('d-m-Y',strtotime($p->created_at))}}</td>
                                            <td>{{$p->created_user->name}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('asset.report.single_product.view', [$p->product->id]) }}"
                                                        class="btn btn-info"><i
                                                            class="fas fa-eye"></i></a>
                                                    @if(Auth::user()->can('edit brand') || Auth::user()->role->id == 1)
                                                        <a href="{{ route('asset.assign.product.edit', $p->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                    @endif
                                                    @if(Auth::user()->can('delete brand') || Auth::user()->role->id == 1)
                                                        <a href="{{ route('asset.setup.brand.destroy', $p->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Distributio Report</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('asset.report.distribution.index') }}" class="btn btn-info">Back</a>
                        </span>

                    </div>
                    <div class="card-body p-5 text-center">
                        <h4>There are no assets</h4>
                    </div>
                </div>
                @endforelse
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
