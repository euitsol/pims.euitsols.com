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
                        <form action="{{ route('asset.assign.product.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="semester_id" value="">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" class="form-control" id="department_id">
                                            <option value="" hidden>All Department</option>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_id">Product</label>
                                        <select name="product_id" class="form-control select" id="product_id" required>
                                            <option value="" hidden>Select Product</option>
                                        </select>
                                        @if ($errors->has('product_id'))
                                            <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-success col-md-4">Search</button>
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
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('select').select2();

            //Product fetch according to Department
            $("#department_id").change(function() {
                productFetch($('#department_id'));
            });
            productFetch($('#department_id'));
        });

        //Product fetch according to  department
        function productFetch(selector) {
           let department_id = selector.val();
            $.ajax({
                url: "{{ route('asset.product_fetch.ajax') }}",
                method: 'GET',
                async: false,
                data: {
                    department_id: department_id,
                },
                success: function(response) {
                    let old_product = "{{old('product_id')}}";
                    var option = "<option value='' hidden>Select Product</option>";
                    $.each(response, function(index, value) {
                        option += `
                        <option value="${value.id}" ${old_product == value.id ? 'selected' : ''}>${value.name}</option>
                        `;
                    });
                    $('#product_id').html(option);
                }
            });
        }
    </script>
@endpush
