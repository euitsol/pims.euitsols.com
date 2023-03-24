@extends('layouts.app')

@section('title', 'Asset Management -Single Product Show')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/js/DataTable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('page_css')
    <style>
        .nav-tabs li {
            border-radius: 10px !important;
        }

        .nav-tabs li .nav-link {
            background: #0c9fce !important;
            color: white;
            border-radius: 7px 7px 0px 0px;

        }

        .nav-tabs li .active {
            background: white !important;
        }

        caption {
            padding-top: 0rem !important;
            caption-side: top !important;
        }

        .bg-warning {
            background-color: #f1f1f1 !important;
        }
    </style>
@endpush
@php
    $qty = 0;
    $total_p = 0;
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <h1 class="text-center" id="product_title">{{ $single_product->name }}</h1>
                <div class="card">
                    <div class="card-header">
                        <h4>Stored Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-warning">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-sm table-info m-auto">
                                                <tbody>
                                                    <tr>
                                                        <th>Department Name</th>
                                                        <td>{{ $single_product->departmentName() }}</td>
                                                        <th>Category Name</th>
                                                        <td>{{ $single_product->category->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sub-category Name</th>
                                                        <td>{{ $single_product->subcategory->name }}</td>
                                                        <th>In Storage (qty)</th>
                                                        <td>{{Number_format( $single_product->totalProduct()) }}</td>
                                                    </tr>
                                                    <tr>

                                                        <th>Total Price</th>
                                                        <td>BDT {{ Number_format($single_product->totalPrice()) }}</td>
                                                        <th>Available Quantity</th>
                                                        <td>{{ Number_format($single_product->qty) }}</td>
                                                    </tr>
                                                    <tr>

                                                        <th>Damage Quantity</th>
                                                        <td>{{ Number_format($single_product->totalDamage()) }}</td>
                                                        <th></th>
                                                        <td></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7 m-auto ">
                                <div class="card bg-warning">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-info ">
                                                <h5>Adding Information</h5>
                                                <thead>
                                                    <tr>
                                                        <th>Quantity</th>
                                                        <th>Warranty</th>
                                                        <th>total Price</th>
                                                        <th>Supplier </th>
                                                        <th>Created At </th>
                                                        <th>Created By </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($single_product->moreProduct as $product)
                                                        <tr>
                                                            <td>{{ Number_format($product->quantity) }}</td>
                                                            <td>{{ $product->warranty }}</td>
                                                            <td>BDT {{ Number_format($product->total_price) }} <span
                                                                    class="taka"></h4>
                                                            </td>
                                                            <td class="supplier-id" id="{{ $product->supplier->id }}">
                                                                {{ $product->supplier->shop_name }}</td>
                                                            <td>{{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                                                            <td>{{ $product->created_user->name }}</td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($assigned_products))
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Assigned Info</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center data-table">
                                    <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Department Name</th>
                                            <th>Section Name</th>
                                            <th>Sub-section Name</th>
                                            <th>Assigned Quantity</th>
                                            <th>Damaged Quantity</th>
                                            <th>Damaged Description</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assigned_products as $key => $assigned_product)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $assigned_product->assignProduct->departmentName() }}</td>
                                                <td>{{ $assigned_product->assignProduct->section->name }}</td>
                                                <td>{{ $assigned_product->assignProduct->subsection->name }}</td>
                                                <td class="assigned-qty">{{ Number_format($assigned_product->qty) }}</td>
                                                <td class="damage-qty">{{ Number_format(optional($assigned_product->damage())->qty) }}</td>
                                                <td class="damage-des">{{ optional($assigned_product->damage())->des }}</td>
                                                {{-- <td class="damage-qty">{{ $assigned_product-> () }}</td> --}}
                                                <td>{{ $assigned_product->created_user->name }}</td>
                                                <td>{{ date('d-m-Y', strtotime($assigned_product->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        @if (Auth::user()->can('edit report') || Auth::user()->role->id == 1)
                                                            <a href="{{ route('asset.assign.product.edit', $assigned_product->id) }}"
                                                                class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                        @endif
                                                        @if (Auth::user()->can('delete report') || Auth::user()->role->id == 1)
                                                            <a href="{{ route('asset.assign.product.destroy', $assigned_product->id) }}"
                                                                class="btn btn-danger btnDelete"><i
                                                                    class="fas fa-trash"></i></a>
                                                        @endif

                                                        @if (Auth::user()->can('damage report') || Auth::user()->role->id == 1)
                                                            <!-- Button trigger modal for damage report-->
                                                            <a href="#"
                                                                data-product="{{ $assigned_product->product_id }}"
                                                                data-id="{{ $assigned_product->id }}"
                                                                class="btn btn-warning btn-damage" data-toggle="modal"
                                                                data-target="#ModalCenter" title="Assign as damage product"
                                                                id=""><i class="fas fa-calendar-times"></i></a>
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

            </div>
        </div>
    </div>

    {{-- Modal for damage report  --}}

    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLongTitle">Damage Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('asset.damage.store') }}"  method="POST">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" value="">
                    <input type="hidden" id="main_assign_id" name="main_assign_id" value="">
                    <input type="hidden" id="supplier_id" name="supplier_id" value="">
                    <button type="submit" id="damage_form2" class="d-none">submit</button>
                    <div class="modal-body">
                        <div>
                            <label for="qty">Damage quantity<span class="text-danger">*</span></label>
                            <input type="text" id="qty" class="form-control"><span class="text-danger"></span>
                            <input type="hidden" id="damate_qty" class="form-control" name="qty">
                        </div>

                        <div>
                            <label for="des">Description</label>
                            <textarea name="des" class="form-control" id="des" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="damage_form" class="btn btn-primary">Save</button>

                    </div>
                </form>
            </div>

        </div>
    </div>


@endsection

@push('third_party_scripts')
    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {



            let assigned_qty = 0;
            $('.btn-damage').on('click', function() {
                let product_id = $(this).data('product');
                let main_assign_id = $(this).data('id');
                let product_title = $('#product_title').text();
                let supplier_id = $('.supplier-id').attr('id');
                let damage_qty = Number($(this).parent().parent().parent().find('.damage-qty').text());
                assigned_qty = Number($(this).parent().parent().parent().find('.assigned-qty').text());
                $('#product_id').val(product_id);
                $('#main_assign_id').val(main_assign_id);
                $('#supplier_id').val(supplier_id);
                $('#ModalLongTitle').text(product_title);
                $('#qty').val(damage_qty);
                $('#des').val($('.damage-des').text());
            });

            $('#qty').on('change keyup', function() {
                let damage_qty = Number($(this).val());
                if (damage_qty > assigned_qty) {
                    $(this).next('span').text("Damage quantity can't be more than assigned quantity")
                } else {
                    $(this).next('span').text(' ');
                }
            })

            $('#damage_form').on('click',function(){
                let damage_qty = $('#qty').val();
                let pattern = /(^[0-9]+(\+|\-|\*|\/)[0-9]+$)|(^[0-9]+$)/;
                if(pattern.test(damage_qty)){
                     damage_qty = Number(eval(damage_qty));
                    $('#qty').next('span').text(' ');
                    if (damage_qty > assigned_qty) {
                        $('#qty').next('span').text(`Damage quantity(${damage_qty}) can't be more than assigned quantity(${assigned_qty})`);
                        return false;
                    } else {
                        $('#qty').next('span').text(' ');
                        $('#damate_qty').val(damage_qty);
                        $('#damage_form2').click();
                    }
                }else{
                    $('#qty').next('span').text('Only number(0-9), +, -, * and / are allowed');
                    return false;
                }
            });


            $('select').select2();
            $('.data-table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    title: 'Product Report',
                    download: 'open',
                    orientation: 'potrait',
                    pagesize: 'LETTER',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }, {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }, 'pageLength']
            });
        });
    </script>
@endpush
