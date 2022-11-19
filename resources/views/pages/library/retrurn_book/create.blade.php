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

            <div class="card" id="book_info">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Assigned Book</h4>
                    </span>

                </div>
                <div class="card-body">
                  <table class="table text-center table-striped">
                    <thead>
                        <tr>
                            <th>S.L</th>
                            <th>Book's name</th>
                            <th>Category</th>
                            <th>Bookshelf</th>
                            <th>Total book</th>
                            <th>Assigning date</th>
                            <th>Return date</th>
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

                $.ajax({
                    type:'get',
                    url: "{{route('library.return_book.info')}}",
                    data:{'id':std_id,},
                    success:function(response){

                        $.each(response,function(index,val){
                            let book_names = '';
                            let bookshelf = '';
                            let category = '';
                            let total_book = '';
                            $.each(val.bkdn,function(key,bkdn){

                                var separetor = '';
                                if(key != 0){ separetor = ', '}
                                total_book += bkdn.qty;
                                 book_names += separetor+`${bkdn.book.name}`;
                                 bookshelf +=  separetor+`${bkdn.book.bookshelf.name}`;
                                 category +=   separetor+`${bkdn.book.category.name}`;
                            });
                            let  book_info = `  <tr>
                                                    <td>
                                                        ${index+1}
                                                    </td>
                                                    <td>
                                                        ${book_names}
                                                    </td>
                                                    <td>
                                                        ${category}
                                                    </td>
                                                    <td>
                                                        ${bookshelf}
                                                    </td>
                                                    <td>
                                                        ${total_book}
                                                    </td>
                                                    <td>
                                                        ${val.assign_date}
                                                    </td>
                                                    <td>
                                                        ${val.return_date}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                                            data-id="${val.id}"><i class="fas fa-eye"></i></a>
                                                            <a href="javascript:void(0)" class="btn btn-success btnView"
                                                            data-id="${val.id}" title='Return the books'><i class="fas fa-arrow-right"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>`;
                            $('#book_info').find('#tbody').append(book_info);
                        });
                    }
                });

               }else{
                $('#select_div').nextAll().remove();
                $('').insertAfter("#select_div");
               }
            });
        });

    </script>
@endpush


