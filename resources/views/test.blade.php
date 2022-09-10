@extends('layouts.app')

@section('title', '')

@push('third_party_stylesheets')

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>
@endpush

@push('page_css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4></h4>
                    </span>
                    <span class="float-right">

                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')
                    <form method="POST" action="{{ url('/test/upload') }}" enctype="multipart/form-data" id="lol_form">
                        @csrf
                    <div class="">
                        <input name="uploadfile" data-actualNmae="image" type="text" class="" id="student-photo" accept="image/*">
                    </div>
                        <input type="submit" value="ss">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('third_party_scripts')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-validate-size/dist/filepond-plugin-image-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
@endpush

@push('page_scripts')
<script>
    $(document).ready(function(){

        //filepond file upload
        file_upload(['#student-photo'], 'uploadfile');
    });


    function file_upload(selectors, name){
        $.each(selectors.reverse(), function( index, selector ) {

            var actualName = $(selector).attr('data-actualNmae');

            const inputElement = document.querySelector(selector);
            const pond = FilePond.create(inputElement);
            pond.setOptions({
                server:{
                    url: '/file-upload',
                    process: {
                        url: '/uploads',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response_data) => {
                            var f_selector = $('input[name="'+name+'"]');
                            $(f_selector).attr('name', actualName);
                            return response_data;

                        },
                        onerror: (response_data) => {
                            console.log(response_data);
                            $(selector).attr('name', $(selector).data('actualNmae'));
                        },
                        ondata: (formData) => {
                            formData.append('name', name);
                            return formData;
                        },
                    },
                    fetch: null,
                    revert: null,
                }
            });
        });


    }
</script>
@endpush

