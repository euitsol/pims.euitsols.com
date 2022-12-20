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
                        <form action="" >
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
                                            <th>Department</th>
                                            <th>Category</th>
                                            <th>Book</th>
                                            <th>Author's Name</th>
                                            <th>Bookshelf</th>
                                            <th>Quantity</th>
                                            <th>Return Date</th>
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
                                                <select class="form-control department_id0 select select2-hidden-accessible"
                                                    data-select2-id="select2-data-3-bkyt" tabindex="-1" aria-hidden="true">
                                                    <option value="" hidden=""
                                                        data-select2-id="select2-data-5-fceg">Select Department</option>
                                                    <option value="1"> C.S.E</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-control cat-id0 select2-hidden-accessible"
                                                    required="" data-select2-id="select2-data-6-13jn" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" hidden=""
                                                        data-select2-id="select2-data-8-nw7d">Select category</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="book[0][book_id]"
                                                    class="form-control book-id book-id0 select2-hidden-accessible"
                                                    required="" data-select2-id="select2-data-9-rlqw" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" hidden=""
                                                        data-select2-id="select2-data-11-9ubs">Select book</option>
                                                </select>
                                            </td>

                                            <td class="author-name">
                                                <span class="form-control">
                                                </span>
                                            </td>

                                            <td class="bookshelf">
                                                <span class="form-control">
                                                </span>
                                            </td>

                                            <td>
                                                <input type="number" name="book[0][qty]"
                                                    class="form-control qty0 text-center" min="1" max=""
                                                    value="1" placeholder="Enter quantity" onchange="bookQty(this)">
                                                <span></span>
                                            </td>

                                            <td>
                                                <input type="text" name="book[0][return_date]"
                                                    class="date date0 form-control" placeholder="Enter return date"
                                                    autocomplete="off" required="">
                                            </td>

                                            <td class="text-left" id="plus_minus_btn">
                                                <span class="btn btn-sm btn-danger minus-btn0"> <i
                                                        class="fas fa-minus"></i></span>
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
                productFetch("section_id",'Section',['department_id'],['created_user','updated_user','deleted_user','department']);
            });
            productFetch("section_id",'Section',['department_id'],['created_user','updated_user','deleted_user','department'],"{{ old('section_id') }}");
             //End Section fetch according to Department

            //Sub-section fetch according to Suction
            $("#section_id").change(function() {
                productFetch("subsection_id",'Subsection',['section_id'],['created_user','updated_user','deleted_user','section']);
            });
            productFetch("subsection_id",'Subsection',['section_id'],['created_user','updated_user','deleted_user','section'],"{{ old('subsection_id') }}");
             //End Sub-section fetch according to Section
        });


        //Product fetch according to  department
        function productFetch(append_element,model,selectors,with_arr,old_value=null) {
            let data_arr = {};
            for(selector in selectors){
                data_arr[selectors[selector]] = $('#'+selectors[selector]).val();
            }
            $.ajax({
                url: "{{ route('asset.product_fetch.ajax') }}",
                method: 'GET',
                async: false,
                data: {
                    'arr': data_arr,
                    'model': model,
                    'with_arr':with_arr,
                },
                success: function(response) {
                    console.log(response);
                    var option = "<option value='' hidden>Select...</option>";
                    $.each(response, function(index, value) {
                        option += `
                        <option value="${value.id}" ${old_value == value.id ? 'selected' : ''}>${value.name}</option>
                        `;
                    });
                    $('#'+append_element).html(option);
                }
            });
        }
    </script>
@endpush
