@extends('layouts.app')

@section('title', 'Library Management - Book Assign')

@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('page_css')
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice__display{
    color: black;
}
caption {
    caption-side: top !important;
}
.plus-btn{
    max-width: 50px;
}
.plus-btn{
    bottom: 95px;
    right: 2.5%;
}
.table th, .table td {
    border-top: none !important;
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
                <div class="card-body position-relative">
                  <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Book</th>
                            <th>Author Name</th>
                            <th>Bookshelf</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr>
                            <td>
                                <select name="book[0][cat_id]" class="form-control" onchange='bookFetch(this,1)'>
                                    <option value="" hidden>Select category</option>
                                    @foreach ($categories as $category )
                                        <option value="{{$category->id}}"> {{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="book[0][book_id]" class="form-control" id="book1" onchange='bookChange(this)'>
                                    <option value="" hidden>Select book</option>
                                </select>
                            </td>
                            <td class="author-name">
                                <span class='form-control'>
                                </span>
                            </td>
                            <td class="bookshelf">
                                <span class='form-control'>
                                </span>
                            </td>
                            <td>
                               <input type="number" name="qty" class="form-control" placeholder="Enter quantity">
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                  </table>
                  <button type="button" id="plus_btn" data-val='2' class="btn btn-success position-absolute plus-btn">+</button>
                  <button class="btn btn-info w-100 mt-4">Save</button>
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
                    success: function (std_info) {
                        let  student_info = `
                                    <div class="row mt-3 p-3" id='std_info'>
                                            <table class="table table-sm table-striped">
                                                <caption>${std_info.name}</caption>
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                Student's name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.name}
                                                            </td>
                                                            <td>
                                                                Student Type
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.std_id ? 'Residential' : 'Non-residential'}
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
                                                                ${std_info.phone}
                                                            </td>
                                                            <td>
                                                                Student Date of Birth
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.dob}
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
                                                                ${std_info.present_address ?? ''}

                                                            </td>
                                                            <td>
                                                                Parmanent Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.permanent_address ?? ''}

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
                                                                ${std_info.ec_name ?? ''}
                                                            </td>
                                                            <td>
                                                                Emergency Contact (Phone)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.ec_phone ?? ''}
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>

                                    </div>`;
                        $('#select_div').nextAll().remove();
                        $(student_info).insertAfter("#select_div");
                    }
                });
               }else{
                $('#select_div').nextAll().remove();
                $('').insertAfter("#select_div");
               }
            });

            //multiple book row add
            $('#plus_btn').click(function(){
                let click_num = Number($(this).attr('data-val'));
                $(this).attr('data-val',click_num+1);
                let tr = `
                        <tr>
                            <td>
                                <select name="book[${click_num-1}][cat_id]" class="form-control" id='cat${click_num}' onchange='bookFetch(this,${click_num})'>
                                    <option value="" hidden>Select category</option>
                                    @foreach ($categories as $category )
                                        <option value="{{$category->id}}"> {{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="book[${click_num-1}][book_id]" class="form-control" id='book${click_num}' onchange='bookChange(this)'>
                                    <option value="" hidden>Select book</option>
                                </select>
                            </td>
                            <td class="author-name">
                                <span class='form-control'>
                                </span>
                            </td>
                            <td class="bookshelf">
                                <span class='form-control'>
                                </span>
                            </td>
                            <td>
                               <input type="number" name="book[${click_num-2}][qty]" class="form-control" placeholder="Enter quantity">
                            </td>
                            <td></td>
                        </tr>`;
                        $('#tbody').append(tr);
            });

        });

        function bookFetch(This,click_num){
            let cat_id = $(This).val();
            $.ajax({
                    type: 'get',
                    url: "{{route('library.book_assign.book_info')}}",
                    data:{
                        'id':cat_id,
                    },
                    success:function(books){

                            var option = "<option val='' hidden>Select book</option>";
                            $.each(books,function(key,book){
                                option += '<option value="'+book.id+'">'+book.name+'</option>';
                            });

                        $('#book'+click_num).html(option);
                        // $(append_book).insertAfter($('#select_cat_div'));
                        $('.select3').select2();
                    }

                })
        }

        function bookChange(This){
           let book_id = $(This).val();

            if(book_id != ''){
                $.ajax({
                    type: 'get',
                    url: "{{route('library.book_assign.single_book_fetch')}}",
                    data:{
                        'id':book_id,
                    },
                    success:function(response){

                        let author_name = `${response.author_name ?? 'finding fail'}`;
                        let bookshelf = `${response.bookshelf.name ?? 'finding fail'}`;
                        $(This).parent().next('td.author-name').children('span').html(author_name);
                        $(This).parent().nextAll('td.bookshelf').children('span').html(bookshelf);

                    }
                })
            }

        }
    </script>
@endpush

