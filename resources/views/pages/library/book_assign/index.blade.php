@extends('layouts.app')

@section('title', 'Library Management - Assign books')
@push('third_party_stylesheets')
    <link href="{{ asset('assets/js/DataTable/datatables.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Assign books</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add book-assign') || Auth::user()->role->id == 1)<a href="{{ route('library.book_assign.create') }}" class="btn btn-info">Assign books</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <table  class="table table-striped text-center" id="table">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Student's name</th>
                                <th>Student's phone</th>
                                <th>Book's Name</th>
                                <th>Total book</th>
                                <th>Assign date</th>
                                <th>Return date</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ( $assigned_books as $key=>$assigned_book)
                                   <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$assigned_book->student->name ?? ''  }}</td>
                                    <td>{{$assigned_book->student->phone ?? '' }}</td>
                                    <td>
                                        @foreach ( $assigned_book->bkdn as $key => $bkdn)
                                            @if ($key != 0) {{'|'}} @endif
                                            {{ $bkdn->book->name}}
                                        @endforeach
                                    </td>
                                   <td>{{$assigned_book->total_book}}</td>
                                    <td>{{ date('d-m-Y',strtotime($assigned_book->assign_date))}}</td>
                                    <td>{{date('d-m-Y',strtotime($assigned_book->return_date))}}</td>
                                    <td>{{$assigned_book->created_user->name}}</td>
                                    <td>{{date('d-m-Y',strtotime($assigned_book->created_user->created_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                            data-id="{{ $assigned_book->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit book-assign') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.book_assign.edit', $assigned_book->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete book-assign') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.book_assign.destroy', $assigned_book->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                   </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
    <script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                dom: 'Bfrtip'
                , buttons: [{
                        extend: 'pdfHtml5'
                        , title: 'Assign books'
                        , download: 'open'
                        , orientation: 'potrait'
                        , pagesize: 'LETTER'
                        , exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7]
                        }
                    }
                    , {
                        extend: 'print'
                        , exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7]
                        }
                    }, 'pageLength'
                ]
            });

             //view-modal
             $('.btnView').click( function(){
                if($(this).data('id') != null || $(this).data('id') != ''){
                    let url = ("{{ route('library.book_assign.show', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    console.log(_url);
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function (response) {
                            console.log(response);
                            $('#view-std_name').html(response.student.name);
                            $('#view-std_phone').html(response.student.phone);
                            $('#view-total-book').html(response.total_book);

                            let book_name = '';
                            let category_name = '';
                            let bookshelf_name = '';
                            $.each(response.bkdn,function(index,val){
                                if(index != 0){
                                    book_name += ', ';
                                    category_name += ', ';
                                    bookshelf_name += ', ';
                                }
                                book_name += val.book.name;
                                category_name += val.book.category.name;
                                bookshelf_name += val.book.bookshelf.name;
                            });
                            $('#view-name').html(book_name);
                            $('#view-cat').html(category_name);
                            $('#view-bookshelf').html(bookshelf_name);
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
            });

        });
    </script>
@endpush
