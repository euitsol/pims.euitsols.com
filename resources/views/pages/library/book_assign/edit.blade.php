@extends('layouts.app')

@section('title', 'Library Management - Update Books')

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
            <form action="{{route('library.book_assign.update')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$assign_book->id}}">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Student selection</h4>
                    </span>
                    <span class="float-right">
                        @if (Auth::user()->can('edit library report') || Auth::user()->role->id == 1)
                        <a href="{{ route('attendance.class',1) }}" class="btn btn-info">Back</a>
                    @endif
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
                                <option value="{{$student->id}}" @if($student->id == $assign_book->std_id) selected @endif> {{ $student->name .' - '. $student->phone }}</option>
                            @endforeach
                            </select>
                            @if($errors->has('std_id')) <span class="text-danger">{{$errors->first('std_id')}}</span> @endif
                        </div>
                    </div>
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
                                            {{ $assign_book->student->name }}
                                        </td>
                                        <td>
                                            Student Type
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $assign_book->std_id ?  'Residential' : 'Non-residential' }}
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
                                            {{ $assign_book->student->phone }}

                                        </td>
                                        <td>
                                            Date of Birth
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ date('d-m-Y',strtotime($assign_book->student->dob) )}}
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
                                             {{ $assign_book->student->present_address ?? ' ' }}
                                        </td>
                                        <td>
                                            Permanent Address
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                             {{ $assign_book->student->permanent_address ?? '' }}

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
                                             {{ $assign_book->student->ec_name ?? '' }}
                                        </td>
                                        <td>
                                            Emergency Contact (Phone)
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                             {{ $assign_book->student->ec_phone ?? '' }}
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
                        <h4>Edit Book</h4>
                    </span>
                </div>
                <div class="card-body">
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
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr>
                            <td>
                                <select class="form-control department_id0 select">
                                    <option value="" hidden>Select Department</option>
                                    @foreach ($departments as $department )
                                        <option value="{{$department->id}}" @if($assign_book->book->category->departments_id == $department->id) selected  @endif> {{ $department->short_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control cat-id0" required>
                                    <option value="" hidden>Select category</option>
                                    @foreach ($categories as $category )
                                        <option value="{{$category->id}}" @if($assign_book->book->category_id== $category->id) selected  @endif>{{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="book_id" class="form-control book-id book-id0" required>
                                    <option value="" hidden>Select book</option>
                                    @foreach ($books as $book )
                                        <option value="{{$book->id}}" @if($assign_book->book->id== $book->id) selected  @endif>{{ $book->name}}</option>
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
                               <input type="number" name="qty" class="form-control qty0 text-center" min="1" max="{{$assign_book->book->qty +    $assign_book->qty}}" value="{{$assign_book->qty}}" placeholder="Enter quantity" onchange="bookQty(this)">
                               <span></span>
                            </td>
                            <td>
                                <input type="text" name="return_date" class="date date0 form-control" value="{{$assign_book->return_date}}" placeholder="Enter return date" autocomplete="off" required>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                  <button class="btn btn-info w-100 mt-4" id="assign_btn">Update</button>
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

            $('.department_id0').on('change',function(){
                let click_num = 0;
                categoryFetch(this,click_num);
            });


            $('.cat-id0').on('change',function(){
                let click_num = 0;
                    bookFetch(this,click_num);
            });

            $('.book-id0').on('change',function(){
                    let click_num = 0;
                    bookChange(this,click_num);
            });

            $('.qty0').on('change keyup',function(){

                bookQty(this);
            });

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


        });

        function bookChange(This,click_num){
           let book_id = $(This).val();

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
                        $('.qty'+click_num).attr('max',response.qty);
                        $('.qty'+click_num).next('span').html('<span class="text-info">Remaining books: </span><span id="text-qty">'+(response.qty-1)+'</span>');
                    }
                })
            }

        }

        function bookQty(This){
            let remaining_book = Number($(This).attr('max'));

            let qty = Number($(This).val());

            let final_book = remaining_book-qty;
            if(final_book >0){
                $(This).next('span').html('<span class="text-info">Remaining books: </span><span id="text-qty">'+final_book+'</span>');
            }
            else if(final_book == 0){
                $(This).next('span').html(`<span class='text-info'>There are no books</span>`);
            }
            else{
                $(This).next('span').html(`<span class='text-danger'>You can't add books more then reserve</span>`);
            }


        }

        function categoryFetch(This,click_num){
                let department_id = $(This).val();
                console.log(click_num);
                if(department_id != ''){
                    let url = "{{route('library.category_fetch',['id'])}}";
                    url = url.replace('id',department_id);

                    $.ajax({
                        type:'get',
                        url: url,
                        success:function(response){

                            let option = '<option value="" hidden> Select department</option>';
                            $.each(response,function(index,val){
                                // console.log(val);
                                option +=  `<option value="${val.id}"> ${val.name}</option>`;
                            });

                        $('select.cat-id'+click_num).html(option);
                        }
                    })
                }else{
                    $('select.cat-id'+click_num).html('<option value="" hidden> Select department</option>');
                }
        }

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
                        $('.book-id'+click_num).html(option);
                    }

                });
        }
    </script>
@endpush

