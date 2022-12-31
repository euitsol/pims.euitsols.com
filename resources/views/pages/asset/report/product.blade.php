@extends('layouts.app')

@section('title', 'Asset Management - Main Storage Report')

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
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Selection</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('asset.report.product.fetch') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-1 offset-md-2">
                                    <label for="user">Department</label>
                                </div>
                                <div class="col-md-6 text-left mt-2">
                                    <select name="department_id" id="department_id" class="form-control">
                                        <option value=""> All </option>
                                        <option value="common_asset" @if (old('department_id') == 'common_asset') selected @endif >Common Asset</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" @if (isset($department_id)) @if ($department_id == $department->id) selected @endif @endif >
                                                {{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('department_id'))
                                        <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1 offset-md-2">
                                    <label for="user">Product</label>
                                </div>
                                <div class="col-md-6 text-left mt-2">
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Select Product</option>
                                    </select>
                                    @if ($errors->has('product_id'))
                                        <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-md-3 text-center m-auto">
                                    <button class="btn btn-info w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('third_party_scripts')
    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('select').select2();
            product_fetch($('#department_id'));
            $('#department_id').on('change',function(){
              product_fetch(this);
            });


            function product_fetch(This){
                let department_id = $(This).val();
                let data_obj = {};

               if(!department_id){
               }
               else if(department_id == 'common_asset'){
                data_obj.department_id = null;
               }
               else{
                data_obj.department_id = department_id;
               }
               ajaxDataFetch('Product',data_obj,['moreProduct'],null,$('#product_id'));
            }
        });
    </script>
@endpush
