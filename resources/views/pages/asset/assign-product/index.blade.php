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
                                        <select name="department_id" class="form-control" id="department_id" required>
                                            <option value="" hidden>Select Department</option>
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
                var department_id = $('#department_id').val();
                productFetch(department_id);
            });

            //Product value keep exist during return back
            let old_department_id = '{{old('department_id') ?? ''}}';

            if( old_department_id != ''){
                productFetch(old_department_id);
            }


            //Old subject fetch
            var old_subject_id = '{{ old('subject_id') ?? '' }}';
            if (old_subject_id != '') {
                var session_id = $('#session_id').val();
                var department_id = $('#department_id').val();
                var semester_id = $('#semester_id').val();
                subjectFetch(session_id, department_id, semester_id);
                $('#subject_id').val({{ old('subject_id') }}).trigger('change.select2');
            }


            //Teacher fetch according to Subject, Group, Shift
            $("#subject_id, #group_id, #shift_id").change(function() {
                var subject_id = $('#subject_id').val();
                var group_id = $('#group_id').val();
                var shift_id = $('#shift_id').val();
                teacherFetch(subject_id, group_id, shift_id);
            });

            //Teacher value keep exist during return back
            let old_group_id = '{{old('group_id') ?? ''}}';
            let old_shift_id = '{{old('shift_id') ?? ''}}';
            if( old_subject_id != '' && old_group_id != '' && old_shift_id != '' ){
                teacherFetch(old_subject_id,old_group_id,old_shift_id);
            }

            //Old teacher check
            var old_teacher_id = '{{ old('teacher_id') ?? '' }}';
            if (old_teacher_id != '') {
                teacherFetch(old_teacher_id);
                $('#teacher_id').val({{ old('teacher_id') }}).trigger('change.select2');
            }

        });

        //Product fetch according to  department
        function productFetch(department_id) {
            $.ajax({
                url: "{{ route('asset.product_fetch.ajax') }}",
                method: 'GET',
                async: false,
                data: {
                    department_id: department_id,
                },
                success: function(response) {
                    var option = "<option value='' hidden>Select Product</option>";
                    $.each(response, function(index, value) {
                        option += `
                        <option value="${value.id}">${value.name}</option>
                        `;
                    });
                    $('#product_id').html(option);
                }
            });
        }

        //Teacher fetch according to subject
        function teacherFetch(subject_id, group_id, shift_id) {
            $.ajax({
                url: "{{ route('teacher_fetch.ajax') }}",
                method: 'GET',
                async: false,
                data: {
                    subject_id: subject_id,
                    group_id: group_id,
                    shift_id: shift_id,
                },
                success: function(response) {
                    var option = "<option value='' hidden>Select Teacher</option>";
                        $.each(response, function(index, value) {
                            option += `
                        <option value="${value.teacher.id}">${value.teacher.name}</option>
                        `;
                        });

                    $('#teacher_id').html(option);
                }
            });
        }
    </script>
@endpush
