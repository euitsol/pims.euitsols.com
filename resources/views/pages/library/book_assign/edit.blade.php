@extends('layouts.app')

@section('title', 'Library Management - Edit Book Assign')

@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('page_css')
<style>

</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">

            <form action="{{route('library.book_assign.update')}}" method="POST">
                @csrf
                <input type="hidden" name="assig_book_id" value="{{ $assign_book->id }}">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Student selection</h4>
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
                                        <option value="{{$student->id}}" @if($assign_book->std_id == $student->id) selected @endif> {{ $student->name .' - '. $student->phone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4 p-4" id='std_info'>
                            <table class="table table-sm table-striped">
                                <tbody>
                                        <tr>
                                            <td>
                                                Student's Name
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                {{$assign_book->student->name}}
                                            </td>
                                            <td>
                                                Student Type
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                {{$assign_book->student->std_id ? 'Residential' : 'Non-residential'}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Student's Phone
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                {{$assign_book->student->phone}}
                                            </td>
                                            <td>
                                                 Date of Birth
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                {{$assign_book->student->dob}}
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
                                                {{$assign_book->student->present_address ?? ''}}

                                            </td>
                                            <td>
                                                Permanent Address
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                {{$assign_book->student->permanent_address ?? ''}}

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
                                                {{$assign_book->student->ec_name ?? ''}}
                                            </td>
                                            <td>
                                                Emergency Contact (Phone)
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                {{$assign_book->student->ec_phone ?? ''}}
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card book-select-card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Assign Book</h4>
                        </span>
                        <span class="float-right">
                        <div class="input-group">
                            <label for="date" class="align-self-center mr-2">Returning date:</label>
                            <input type="text" id="date" name="return_date" class="date form-control" placeholder="Enter return date" value="{{$assign_book->return_date}}" autocomplete="off" required>
                        </div>
                            @if($errors->has('return_date')) <span class="text-danger">{{$errors->first('return_date')}}</span> @endif
                        </span>

                    </div>
                    <div class="card-body" >

                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Book</th>
                                    <th>Author's Name</th>
                                    <th>Bookshelf</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                    <tr>
                                        <td>
                                            <select class="form-control cat-id" onchange='bookFetch(this)' required>
                                                <option value="" hidden>Select category</option>
                                                @foreach ($categories as $category )
                                                    <option value="{{$category->id}}" @if($category->id == $assign_book->book->category_id) selected @endif> {{ $category->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="book[0][book_id]" class="form-control book-id" onchange='bookChange(this)' required>
                                                <option value="" hidden>Select book</option>
                                                @foreach ($books as $book )
                                                <option value="{{$book->id}}" @if($book->id == $assign_book->book_id) selected @endif> {{ $book->name}}</option>
                                            @endforeach
                                            </select>

                                        </td>
                                        <td class="author-name">
                                            <span class='form-control'>
                                                {{$assign_book->book->author_name}}
                                            </span>
                                        </td>
                                        <td class="bookshelf">
                                            <span class='form-control'>
                                                {{$assign_book->book->bookshelf->name}}
                                            </span>
                                        </td>
                                        <td>
                                        <input type="number" name="book[0][qty]" class="form-control qty text-center" min="1" max="{{$assign_book->book->qty}}" value="{{$assign_book->qty}}" placeholder="Enter quantity" onkeyup="bookQty(this)">
                                        <span><span class="text-info">Remaing books: </span><span>{{$assign_book->book->qty - $assign_book->qty}}</span></span>
                                        </td>
                                        <td class="text-left" id="plus_minus_btn">
                                            <span class="btn btn-info plus-btn " onclick='add(this)'>+</span>
                                            <span class="btn btn-danger minus-btn d-none" onclick='remove(this)'>-</span>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-info w-100 mt-4" id="assign_btn">Update</button>
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
            $('select').select2();

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

                        let student_info = `
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
                                       `;
                        // $(student_info).insertAfter("#select_div");
                        $("#select_div").next('#std_info').html(student_info);
                    }
                });
               }else{
                $("#select_div").next('#std_info').html('');
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

            $('#assign_btn').click(function(){
                if($(this).attr('type') == 'button'){
                   toastr.error("Please, select all input field");
                 }
            });
        });

        function bookFetch(This){
            let index_no = $('.cat-id').index(This);
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
                        $('.book-id').eq(index_no).html(option);


                    }

                })
        }

        function bookChange(This){
           let book_id = $(This).val();
           let index_no = $('.book-id').index(This);
           //duplicate validation
           let check = 0;
            $('.book-id').each(function(index){
                if(book_id == $(this).val()){
                    check++;
                }
            });
            $(This).nextAll('p').remove();
            if(check>1){
                $('<p class="text-danger">This book already you have been taken </p>').insertAfter($(This).next());
                $('#assign_btn').attr('type','button');
                return false;
            }

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
                        $('.qty').eq(index_no).attr('max',response.qty);
                        $('.qty').eq(index_no).next('span').html('<span class="text-info">Remaingin books: </span><span id="text-qty">'+(response.qty-1)+'</span>');

                        $('#assign_btn').attr('type','submit');
                        $('.book-id').each(function(index){
                            if($(this).val() == ''){
                                $('#assign_btn').attr('type','button');
                            }
                        });

                    }
                });
            }

        }

        function add(This){
            let click_num = Number($('.plus-btn').index(This))+1;
                let tr = `
                        <tr>
                            <td>
                                <select class="form-control cat-id select" onchange='bookFetch(this)'>
                                    <option value="" hidden>Select category</option>
                                    @foreach ($categories as $category )
                                        <option value="{{$category->id}}"> {{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="book[${click_num}][book_id]" class="form-control book-id" id='book${click_num}' onchange='bookChange(this)'>
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
                               <input type="number" name="book[${click_num}][qty]" class="form-control qty text-center" min="1" max="" value="1"  placeholder="Enter quantity" onkeyup="bookQty(this)">
                               <span></span>
                            </td>
                            <td class="text-left" id="plus_minus_btn">
                                <span class="btn  btn-info plus-btn" onclick='add(this)'>+</span>
                                <span class="btn btn-danger d-none minus-btn" onclick='remove(this)'>Remove</span>
                            </td>
                        </tr>`;

                $('#tbody').append(tr);
                $(This).next('span.minus-btn').removeClass('d-none');
                $(This).addClass('d-none');
                $('select').select2();
                $('#assign_btn').attr('type','button');
        }

        function remove(This){
            let index_no  = $('.minus-btn').index(This);
            $('.book-id').eq(index_no).attr('disabled',true);
            $('.cat-id').eq(index_no).attr('disabled',true);
            $('.qty').eq(index_no).attr('disabled',true);
            $('.book-id').eq(index_no).parent().parent().addClass('d-none');
            $('.book-id').eq(index_no).removeClass('book-id');
            $('.cat-id').eq(index_no).removeClass('cat-id');
            $('.qty').eq(index_no).removeClass('qty');
            $(This).removeClass('minus-btn');
        }
        function bookQty(This){
            let remaining_book = Number($(This).attr('max'));
            console.log(remaining_book);

            let qty = Number($(This).val());

            let final_book = remaining_book-qty;
            if(final_book >0){
                $(This).next('span').html('<span class="text-info">Remaingin books: </span><span id="text-qty">'+final_book+'</span>');
            }
            else if(final_book == 0){
                $(This).next('span').html(`<span class='text-info'>There are no books</span>`);
            }
            else{
                $(This).next('span').html(`<span class='text-danger'>You can't add books more then reserve</span>`);
            }


        }

    </script>
@endpush

