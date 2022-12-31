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
.table th, .table td {
    border-top: none !important;
}

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
.badge{
    top: 0px;
    right: 0px;
}
.nav-item a{
    padding-right: 22px
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

            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Previous assigned books</h4>
                    </span>
                </div>
                <div class="card-body" >
                    <ul class="nav nav-tabs">
                        <li class="nav-item border border-bottom-0"  data-toggle="tab">
                            <a href="#assigned" class="nav-link active assigned position-relative" data-toggle="tab">Assigned  <span class="badge badge-warning position-absolute">0</span></a>
                        </li>
                        <li class="nav-item border border-bottom-0"  data-toggle="tab">
                            <a href="#returned" class="nav-link returned position-relative" data-toggle="tab">Returned <span class="badge badge-warning position-absolute">0</span></a>
                        </li>
                        <li class="nav-item border border-bottom-0"  data-toggle="tab">
                            <a href="#dew" class="nav-link dew position-relative" data-toggle="tab">Dew <span class="badge badge-warning position-absolute">0</span></a>
                        </li>
                    </ul>

                    <div class="tab-content p-4 border border-top-0">
                        <div class="tab-pane active" id="assigned">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <caption class='text-center'>Assigned books information</caption>
                                    <thead>
                                        <tr>
                                            <th>Book's name</th>
                                            <th>Author name</th>
                                            <th>Quantity</th>
                                            <th>Assign date</th>
                                            <th>Return date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="returned">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <caption class='text-center'>Returned books information</caption>
                                    <thead>
                                        <tr>
                                            <th>Book's name</th>
                                            <th>Author name</th>
                                            <th>Quantity</th>
                                            <th>Assign date</th>
                                            <th>Return date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="dew">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <caption class='text-center'>Dew books information</caption>
                                    <thead>
                                        <tr>
                                            <th>Book's name</th>
                                            <th>Author name</th>
                                            <th>Quantity</th>
                                            <th>Assign date</th>
                                            <th>Return date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
                                <th class="text-left" >
                                    <span class="btn btn-info plus-btn" id="0">
                                        <i class='fas fa-plus'></i>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr>
                                <td>
                                    <select class="form-control department_id0 select">
                                        <option value="" hidden>Select Department</option>
                                        @foreach ($departments as $department )
                                            <option value="{{$department->id}}"> {{ $department->short_name}}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control cat-id0" required>
                                        <option value="" hidden>Select category</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="book[0][book_id]" class="form-control book-id book-id0" required>
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
                                   <input type="number" name="book[0][qty]" class="form-control qty0 text-center" min="1" max="" value="1" placeholder="Enter quantity" onchange="bookQty(this)">
                                   <span></span>
                                </td>

                                <td>
                                    <input type="text" name="book[0][return_date]" class="date date0 form-control" placeholder="Enter return date" autocomplete="off" required>
                                </td>

                                <td class="text-left" id="plus_minus_btn">
                                    <span class="btn btn-sm btn-danger minus-btn0"> <i class='fas fa-minus'></i></span>
                                </td>
                            </tr>
                        </tbody>

                      </table>
                 </div>

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

            $('.department_id0').on('change',function(){
                let click_num = 0;
                categoryFetch(this,click_num);
            });

            $('.plus-btn').on('click',function(){
                    add(this);
                    // alert($(this).data('id'))
            });

            $('.minus-btn0').on('click',function(){
                let click_num = 0;
                    remove(this,click_num);
            });

            $('.cat-id0').on('change',function(){
                let click_num = 0;
                    bookFetch(this,click_num);
            });

            $('.book-id0').on('change',function(){
                    check();
                    let click_num = 0;
                    bookChange(this,click_num);
            });

            $('.date').on('click change keyup',function(){
                    check();
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
                                    <div class="row table-responsive mt-3 p-3" id='std_info'>
                                            <table class="table table-sm table-striped">
                                                <caption class='text-center'>Student information</caption>
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                Student's Name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.student.name}
                                                            </td>
                                                            <td>
                                                                Student Type
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.student.std_id ? 'Residential' : 'Non-residential'}
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
                                                                ${std_info.student.phone}
                                                            </td>
                                                            <td>
                                                                Date of Birth
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.student.dob}
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
                                                                ${std_info.student.present_address ?? ''}

                                                            </td>
                                                            <td>
                                                                Permanent Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.student.permanent_address ?? ''}

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
                                                                ${std_info.student.ec_name ?? ''}
                                                            </td>
                                                            <td>
                                                                Emergency Contact (Phone)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                ${std_info.student.ec_phone ?? ''}
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                    </div>`;
                        $('#select_div').nextAll().remove();
                        $(student_info).insertAfter("#select_div");
                    }
                });

                $.ajax({
                    type: 'get',
                    url:"{{route('library.book_assign.transection')}}",
                    data:{'id':std_id},
                    success:function(response){
                        // console.log(response)
                        let assigned = '';
                        let returned = '';
                        let dew = '';

                        $.each(response.assigned,function(index,val){
                            assigned += `
                                <tr>
                                    <td> ${val.book.name}</td>
                                    <td> ${val.book.author_name}</td>
                                    <td> ${val.qty}</td>
                                    <td> ${val.assign_date}</td>
                                    <td> ${val.return_date}</td>
                                </tr>
                            `;
                        });
                        $.each(response.returned,function(index,val){
                            returned += `
                                <tr>
                                    <td> ${val.book.name}</td>
                                    <td> ${val.book.author_name}</td>
                                    <td> ${val.qty}</td>
                                    <td> ${val.assign_date}</td>
                                    <td> ${val.return_date}</td>
                                    <td> ${val.return_date> val.returned_date ? 'Timely returned' : 'Delay returned'}</td>
                                </tr>
                            `;
                        });
                        $.each(response.dew,function(index,val){
                            dew += `
                                <tr>
                                    <td> ${val.book.name}</td>
                                    <td> ${val.book.author_name}</td>
                                    <td> ${val.qty}</td>
                                    <td> ${val.assign_date}</td>
                                    <td> ${val.return_date}</td>
                                </tr>
                            `;
                        });
                    $('#assigned').find('tbody').html(assigned);
                    $('#returned').find('tbody').html(returned);
                    $('#dew').find('tbody').html(dew);
                    $('.assigned').find('.badge').html(response.assigned.length)
                    $('.returned').find('.badge').html(response.returned.length)
                    $('.dew').find('.badge').html(response.dew.length)
                    }
                })
               }else{
                $('#select_div').nextAll().remove();
                $('').insertAfter("#select_div");
               }
            });
        });

        function add(This)
        {
            let click_num = Number($(This).attr('id'))+1;
            $(This).attr('id',click_num);

            if( $('.book-id').length>4){
                toastr.warning('You can not add more than five books')
                return false;
           }
                let tr = `
                        <tr>
                            <td>
                                <select class="form-control department_id${click_num}">
                                    <option value="" hidden>Select Department</option>
                                    @foreach ($departments as $department )
                                        <option value="{{$department->id}}"> {{ $department->short_name}}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <select class="form-control cat-id${click_num}">
                                    <option value="" hidden>Select category</option>

                                </select>
                            </td>
                            <td>
                                <select name="book[${click_num}][book_id]" class="form-control book-id book-id${click_num}" id='book${click_num}'>
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
                               <input type="number" name="book[${click_num}][qty]" class="form-control text-center qty${click_num}" min="1" max="" value="1"  placeholder="Enter quantity">
                               <span></span>
                            </td>
                            <td>
                                <input type="text" name="book[${click_num}][return_date]" class="date date${click_num} form-control" placeholder="Enter return date" autocomplete="off" required>
                            </td>
                            <td class="text-left" id="plus_minus_btn">
                                <span class="btn btn-sm btn-danger minus-btn${click_num}"> <i class='fas fa-minus'></i></span>
                            </td>
                        </tr>`;

                $('#tbody').append(tr);

                $('.date'+click_num).datepicker({
                    autoclose:true,
                });

                $('select').select2();
                $('#assign_btn').attr('type','button');

                //minus button
                $('.minus-btn'+click_num).on('click',function(){
                    remove(this,click_num);
                });

                $('.qty'+click_num).on('change keyup',function(){
                    bookQty(this);
                });

                $('.date'+click_num).on('click change keyup',function(){
                    check();
                });

                $('.book-id'+click_num).on('change',function(){
                    check();
                    bookChange(this,click_num);
                });

                $('.department_id'+click_num).on('change',function(){
                    categoryFetch(this,click_num);
                });

                $('.cat-id'+click_num).on('change',function(){
                    bookFetch(this,click_num);
                });


        }

        function remove(This,click_num){
           if( $('.book-id').length<2){
                toastr.error('You have to keep at least one')
                return false;
           }
            $('.book-id'+click_num).prop('disabled',true);
            $('.cat-id'+click_num).prop('disabled',true);
            $('.qty'+click_num).prop('disabled',true);
            $('.date'+click_num).prop('disabled',true);
            $('.book-id'+click_num).parent().parent().addClass('d-none');
            $('.book-id'+click_num).removeClass('book-id');
            $('.date'+click_num).removeClass('date');

        }

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

