@extends('layouts.app')

@section('title', 'Library Management - Returning Books')

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
                        {{-- @dd(old('std_id')) --}}
                        <div class="col-md-6 text-left " >
                            <select name="std_id" id="std_id" class="form-control" required>
                                <option value="" hidden>Select student</option>
                                @foreach ($students as $student )
                                <option value="{{$student->id}}" > {{ $student->name .' - '. $student->phone }}</option>
                            @endforeach
                            </select>
                            @if($errors->has('std_id')) <span class="text-danger">{{$errors->first('std_id')}}</span> @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" id="book_info">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Return Book</h4>
                    </span>

                </div>
                <div class="card-body">
                  <table class="table text-center table-striped">
                    <thead>
                        <tr>
                            <th>S.L</th>
                            <th>Book's name</th>
                            <th>Department name</th>
                            <th>Category</th>
                            <th>Bookshelf</th>
                            <th>Total book</th>
                            <th>Assigned date</th>
                            <th>Return date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                  </table>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

{{-- Modals --}}
<div class="modal fade" id="view-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Details <span id="view-header"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-10 m-auto">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped" >
                            <tbody id="view-tbody">
                                <tr>
                                    <td>student's Name</td>
                                    <td>
                                        <span id="view-std_name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>student's Phone</td>
                                    <td>
                                        <span id="view-std_phone"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total book</td>
                                    <td>
                                        <span id="view-total-book"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>book's Name</td>
                                    <td>
                                        <span id="view-name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Department Name</td>
                                    <td>
                                        <span id="view-department-name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Categories</td>
                                    <td>
                                        <span id="view-cat"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bookshelves</td>
                                    <td>
                                        <span id="view-bookshelf"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Assigned date</td>
                                    <td>
                                        <span id="view-assign_date"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Return date</td>
                                    <td>
                                        <span id="view-return_date"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Created At</td>
                                    <td>
                                        <span id="view-createdAt"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Created By</td>
                                    <td>
                                        <span id="view-createdBy"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Updated At</td>
                                    <td>
                                        <span id="view-updatedAt"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Updated By</td>
                                    <td>
                                        <span id="view-updatedBy"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
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
           //Single student fetch. to implement this just use one id that is #select_div use for the parent of select student id and try to avoid #select_div's next element
            $('#select_div').find('select').change(function(){
               let std_id = $(this).val();
               stdChange(std_id);
            });

            function stdChange(std_id){
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
                    type:'get',
                    url: "{{route('library.return_book.info')}}",
                    data:{'id':std_id,},
                    success:function(response){
                        let date = new Date();
                        let today_date  = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
                        console.log(today_date)
                            var t_date = Date.parse(today_date);
                        $('#book_info').find('#tbody').children().remove();
                        $.each(response,function(index,val){

                            let assign_btn = '';
                            let title = '';
                            let btn_class = '';
                            let status = '';
                            if(t_date > Date.parse(val.return_date)){
                               assign_btn = "{{route('library.return_book.payment')}}?id="+ val.id
                               title = 'Pay fee';
                               btn_class = 'btn-danger';
                               status = 'Fee aplicable';
                            }else{
                                assign_btn = "javascript:void(0)"
                               title = 'Return the books';
                               btn_class = 'btn-success update-btn'+val.id;
                               status = 'Fee not aplicable';
                            }

                                 let  book_info = `
                                                <tr>
                                                    <td>
                                                        ${index+1}
                                                    </td>
                                                    <td>
                                                        ${val.book.name}
                                                    </td>
                                                    <td>
                                                        ${val.book.category.department.short_name}
                                                    </td>
                                                    <td>
                                                        ${val.book.category.name}
                                                    </td>
                                                    <td>
                                                        ${val.book.bookshelf.name}
                                                    </td>
                                                    <td>
                                                        ${val.qty}
                                                    </td>
                                                    <td>
                                                        ${val.assign_date}
                                                    </td>
                                                    <td>
                                                        ${val.return_date}
                                                    </td>
                                                    <td>
                                                        ${status}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" class="btn btn-info btnView${val.id}"
                                                            data-id="${val.id}" ><i class="fas fa-eye"></i></a>
                                                            <a href="${assign_btn}" class="btn ${btn_class}"
                                                            data-id="${val.id}" title='${title}'><i class="fas fa-arrow-right"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>`;
                                $('#book_info').find('#tbody').append(book_info);

                                $('.btnView'+val.id).on('click',function(){
                                    btnView(this);
                                });
                                $('.update-btn'+val.id).on('click',function(){
                                    updateBook(this);
                                });
                        });
                    }
                });

               }else{
                $('#select_div').nextAll().remove();
                $('').insertAfter("#select_div");
               }
            }
            function updateBook(This){

                alert('Are you sure??');
                let book_assign_id = $(This).data('id');
                console.log(book_assign_id);
                let url = "{{route('library.return_book.update',['id'])}}"
                url = url.replace('id',book_assign_id);
                $.ajax({
                    type: 'get',
                    url: url,
                    success:function(response){
                        if(response==1){
                            toastr.success('Book returned successfully')
                        }else{
                            toastr.error("Something went wrong")
                        }
                            let std_id = $('#select_div').find('select').val();
                            stdChange(std_id);
                    }
                });
            }

            //view-modal
            function btnView(This){
                if($(This).data('id') != null || $(This).data('id') != ''){
                    let url = ("{{ route('library.return_book.show', ['id']) }}");
                    let _url = url.replace('id', $(This).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function (response) {
                            // console.log(response);
                            $('#view-std_name').html(response.student.name);
                            $('#view-std_phone').html(response.student.phone);
                            $('#view-total-book').html(response.qty);
                            $('#view-name').html(response.book.name);
                            $('#view-name').html(response.book.category.department.department_name);
                            $('#view-cat').html(response.book.category.name);
                            $('#view-bookshelf').html(response.book.bookshelf.name);
                            $('#view-assign_date').html(response.assign_date);
                            $('#view-return_date').html(response.return_date);
                            $('#view-createdAt').html(response.created_at ? new Date(response.created_at) : '');
                            $('#view-createdBy').html(response.created_user ? response.created_user.name : 'system');
                            $('#view-updatedAt').html(response.updated_at ? new Date(response.updated_at) : '');
                            $('#view-updatedBy').html(response.updated_user ? response.updated_user.name: '');
                            $('#view-modal').modal('show');
                        }
                    });
                }else{
                    alart('Something went wrong');
                }
            }


        });

    </script>
@endpush


