@extends('layouts.app')

@section('title', 'Library Management - Book Assign')

@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('page_css')
<style>
    .book-select-card{
    display: none;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <form action="{{route('library.book_assign.store')}}" method="POST">
                @csrf
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Book assign</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add book-assign') || Auth::user()->role->id == 1)<a href="{{ route('library.book_assign.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body" >
                    <div class="row" id="select_div">
                        <div class="col-md-1 offset-md-2">
                            <label for="std_id">Students<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-6 text-left " >
                            <select name="std_id" id="std_id" class="form-control select2">
                                <option value="" hidden>Select student</option>
                                @foreach ($students as $student )
                                    <option value="{{$student->id}}"> {{ $student->name .' - '. $student->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card book-select-card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Assign Book</h4>
                    </span>
                    <span class="float-right">

                </div>
                <div class="card-body" >
                    <div class="row" id="select_cat_div">
                        <div class="col-md-1 offset-md-2">
                            <label for="cat_id">Categories<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-6 mr-auto">
                            <select name="cat_id" id="cat_id" class="form-control select2">
                                <option value="" hidden>Select category</option>
                                @foreach ($categories as $category )
                                    <option value="{{$category->id}}"> {{ $category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
            $('.select2').select2();

           //Single student fetch. to implement this just use one id that is #select_div use for the parent of select student id and try to avoid #select_div's next element
            $('#select_div').find('select').change(function(){
               let std_id = $(this).val();
               if(std_id != ''){
                $.ajax({
                    type: "get",
                    url: "{{route('library.book_assign.info')}}",
                    data: {
                        'id' : std_id
                    },
                    success: function (response) {
                        // console.log(response.std_id);

                        let student_info = `
                                        <div class="row mt-4 p-4" id='std_info'>
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                Student's name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.name}
                                                            </td>
                                                            <td>
                                                                Student Type
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.std_id ? 'Residential' : 'Non-residential'}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Student Phone
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.phone}
                                                            </td>
                                                            <td>
                                                                Student Date of Birth
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.dob}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                Present Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.present_address ?? ''}

                                                            </td>
                                                            <td>
                                                                Parmanent Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.permanent_address ?? ''}

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Emergency Contact (Name)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.ec_name ?? ''}
                                                            </td>
                                                            <td>
                                                                Emergency Contact (Phone)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${response.ec_phone ?? ''}
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                       `;

                        $('#select_div').nextAll().remove();
                        $(student_info).insertAfter("#select_div");
                        $('.book-select-card').css('display','block')
                    }
                });
               }else{
                $('#select_div').nextAll().remove();
                $('.book-select-card').css('display','none')
                $('.book-select-card').find('select').val('').trigger('change');
                $('').insertAfter("#select_div");
               }
            });

            $('#select_cat_div').find('select').on('change',function(){
                let cat_id = $(this).val();
                $.ajax({
                    type: 'get',
                    url: "{{route('library.book_assign.book_info')}}",
                    data:{
                        'id':cat_id,
                    },
                    success:function(books){

                            var option = '<option value="" hidden>Select book</option>';
                            $.each(books,function(key,book){
                                option += '<option value="'+book.id+'">'+book.name+'</option>';
                            });
                            // console.log(option);
                        let append_book =   `
                                            <div class='row mt-3' id="select_book_div">
                                                <div class="col-md-1 offset-md-2">
                                                    <label for="book_id">Books<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-6 mr-auto">
                                                    <select name="book_id" id="book_id" class="form-control select3" onchange='bookChange(this)'>
                                                        ${option}
                                                    </select>
                                                </div>
                                            </div>
                                            `;
                        $('#select_cat_div').nextAll().remove();
                        $(append_book).insertAfter($('#select_cat_div'));
                        $('.select3').select2();
                    }

                })
            });
        });

        function bookChange(This){
           let book_id = $(This).val();
            $.ajax({
                type: 'get',
                url: "{{route('library.book_assign.single_book_fetch')}}",
                data:{
                    'id':book_id,
                },
                success:function(book){
                    console.log(book);

                    let book_info = `  <div class="row mt-4 p-4" id='std_info'>
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                Book's name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${book.name}
                                                            </td>
                                                            <td>
                                                                Book Type
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${book.author_name ? 'Residential' : 'Non-residential'}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                               Category Name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${book.category.name}
                                                            </td>
                                                            <td>
                                                                Bookshelf Name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${book.bookshelf.name}
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 m-auto  mt-5">
                                                <button type='submit' class='btn btn-info w-100'>Save</button>
                                            </div>
                                        </div>`;
                    $(This).parent().parent().nextAll().remove();
                    $(book_info).insertAfter($(This).parent().parent());

                }
            })

        }
    </script>
@endpush

