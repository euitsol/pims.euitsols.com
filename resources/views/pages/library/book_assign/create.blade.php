@extends('layouts.app')

@section('title', 'Library Management - Assign Books')

@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/Datepicker/datepicker.min.css')}}">
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
                        <h4>Student selection</h4>
                    </span>
                </div>
                <div class="card-body" >
                    <div class="row" id="select_div">
                        <div class="col-md-1 offset-md-2">
                            <label for="std_id">Students<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-6 text-left " >
                            <select name="std_id" id="std_id" class="form-control" required>
                                <option value="" hidden>Select student</option>
                                @foreach ($students as $student )
                                <option value="{{$student->id}}"> {{ $student->name .' - '. $student->phone }}</option>
                            @endforeach
                            </select>
                            @if($errors->has('std_id')) <span class="text-danger">{{$errors->first('std_id')}}</span> @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card book-select-card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Assign Book</h4>
                    </span>
                </div>
                <div class="card-body">
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
                                <select class="form-control cat-id select" onchange='bookFetch(this)' required>
                                    <option value="" hidden>Select category</option>
                                    @foreach ($categories as $category )
                                        <option value="{{$category->id}}"> {{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="book[0][book_id]" class="form-control book-id book" required>
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
                               <input type="number" name="book[0][qty]" class="form-control qty text-center" min="1" max="" value="1" placeholder="Enter quantity" onchange="bookQty(this)">
                               <span></span>
                            </td>
                            <td>
                                <input type="text" name="book[0][return_date]" class="date form-control" placeholder="Enter return date" autocomplete="off" required>
                            </td>

                            <td class="text-left" id="plus_minus_btn">
                                <span class="btn btn-info plus-btn"   onclick='add(this)'>+</span>
                                <span class="btn btn-sm btn-danger d-none minus-btn" onclick='remove(this)'>Remove</span>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                  <button type="button" class="btn btn-info w-100 mt-4" id="assign_btn">Assign</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@push('third_party_scripts')
    <script src="{{asset('assets/js/Datepicker/datepicker.min.js')}}"></script>
     {{-- Select2 --}}
     <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {

            $('.date').datepicker({
                autoclose:true,
            });

            $('select').select2();

            $('.date').on('click change keyup',function(){
                    check();
            });
            $('.book').on('change',function(){
                check();
                bookChange(this)
            });

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
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                Student's Name
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
                                                                Student's Phone
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.phone}
                                                            </td>
                                                            <td>
                                                                Date of Birth
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
                                                                Permanent Address
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
                    }
                })
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
                                <select name="book[${click_num}][book_id]" class="form-control book-id book${click_num}" id='book${click_num}'>
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
                               <input type="number" name="book[${click_num}][qty]" class="form-control qty qty${click_num}" min="1" max="" value="1"  placeholder="Enter quantity">
                               <span></span>
                            </td>
                            <td>
                                <input type="text" name="book[${click_num}][return_date]" class="date date${click_num} form-control" placeholder="Enter return date" autocomplete="off" required>
                            </td>
                            <td class="text-left" id="plus_minus_btn">
                                <span class="btn  btn-info plus-btn" onclick='add(this)'>+</span>
                                <span class="btn btn-sm btn-danger d-none minus-btn" onclick='remove(this)'>Remove</span>
                            </td>
                        </tr>`;

                $('#tbody').append(tr);

                $('.date'+click_num).datepicker({
                    autoclose:true,
                });

                $(This).next('span.minus-btn').removeClass('d-none');
                $(This).addClass('d-none');
                $('select').select2();
                $('#assign_btn').attr('type','button');
                $('.qty'+click_num).on('change keyup',function(){
                    bookQty(this);
                });

                $('.date'+click_num).on('click change keyup',function(){
                    check();
                });
                $('.book'+click_num).on('change',function(){
                    check();
                    bookChange(this)
                });
        }

        function remove(This){
            let index_no  = $('.minus-btn').index(This);
            console.log(index_no);

            $('.book-id').eq(index_no).attr('disabled',true);
            $('.cat-id').eq(index_no).attr('disabled',true);
            $('.qty').eq(index_no).attr('disabled',true);
            $('.date').eq(index_no).attr('disabled',true);
            $('.book-id').eq(index_no).parent().parent().addClass('d-none');
            $('.book-id').eq(index_no).removeClass('book-id');
            $('.cat-id').eq(index_no).removeClass('cat-id');
            $('.qty').eq(index_no).removeClass('qty');
            $(This).removeClass('minus-btn');
        }

       function bookQty(This){
            let remaining_book = Number($(This).attr('max'));

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

        function check(){
            let date_check = 0;
            let book_check = 0;
            $('.date').each(function(){
                if(!$(this).val()){
                    date_check++;
                }
            });

            $('.book-id').each(function(){
                if(!$(this).val()){
                    book_check++;
                }
            });

            if(!date_check && !book_check){
                $('#assign_btn').attr('type','sumbit');
                console.log('checked');
            }else{
                console.log('uncheked');
            }
        }
    </script>
@endpush

