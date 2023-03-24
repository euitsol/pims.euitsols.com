@extends('layouts.app')

@section('title', 'Library Management - All Report')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">
@endpush

@push('page_css')
    <style>
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

        caption {
            padding-top: 0rem !important;
            caption-side: top !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <form action="{{ route('library.report.all') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Date selection</h4>
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('library.report.all') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-1 offset-md-2">
                                        <label for="date">Date range<span class="text-danger">*</span></label>
                                    </div>
                                    {{-- @dd(old('std_id')) --}}
                                    <div class="col-md-6 text-left ">
                                        <div class="input-group">
                                            <input name="str_date" type="date" id="str_date" class="form-control"
                                                value="{{ $str_date }}">
                                            <span class="input-group-text">to</span>
                                            <input name="end_date" type="date" id="end_date" class="form-control"
                                                value="{{ $end_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 offset-md-2">
                                        <label for="user">Department</label>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value=""hidden>All</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" @if(old('department_id') == $department->id) selected @endif>{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 offset-md-2">
                                        <label for="user">User</label>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option value=""hidden>All</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @if(old('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row  mt-2">
                                    <div class="col-md-3 text-center m-auto">
                                        <button class="btn btn-info w-100">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card" id="book_info">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Report</h4>
                            </span>

                        </div>
                        <div class="card-body">
                            {{-- <div class="nav"> --}}
                            <ul class="nav nav-tabs">
                                <li class="nav-item border border-bottom-0">
                                    <a class="nav-link active" data-toggle="tab" href="#assign">Assigned books</a>
                                </li>
                                <li class="nav-item border ml-1 border-bottom-0">
                                    <a href="#returned" class="nav-link " data-toggle="tab">Returned</a>
                                </li>
                                <li class="nav-item border ml-1 border-bottom-0">
                                    <a href="#return" class="nav-link" data-toggle="tab">Delay</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4 border border-top-0 shadow-sm">
                                <div class="tab-pane active" id="assign">
                                    <div class="table-responsive">
                                        <table class="table text-center border border-1 table-striped">
                                            <caption class="caption text-center">Assigned books</caption>
                                            <thead>
                                                <tr>
                                                    <th>S.L</th>
                                                    <th>Student's name</th>
                                                    <th>Book's name</th>
                                                    <th>Bookshelf</th>
                                                    <th>Total book</th>
                                                    <th>Assigned date</th>
                                                    <th>Return date</th>
                                                    <th>Status</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                @forelse ($assigned_info_all as $key => $n)
                                                    <tr>
                                                        {{-- @dd($n) --}}
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $n->student_name ?? '' }}</td>
                                                        <td>{{ $n->book_name ?? '' }}</td>
                                                        <td>{{ $n->bookshelf_name ?? '' }}</td>
                                                        <td>{{ $n->qty ?? '' }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->assign_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->return_date)) }}</td>
                                                        <td>{{ $n->status }}</td>
                                                        <td>{{ $n->created_by }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->created_at)) }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="javascript:void(0)" class="btn btn-info btnView"
                                                                data-id="{{ $n->id }}"><i class="fas fa-eye"></i></a>
                                                                @if (Auth::user()->can('edit book-assign') || Auth::user()->role->id == 1)
                                                                    <a href="{{ route('library.book_assign.edit', $n->id) }}" class="btn btn-dark btnEdit" target="_blank"><i class="fas fa-edit"></i></a>
                                                                @endif
                                                                @if (Auth::user()->can('delete book-assign') || Auth::user()->role->id == 1)
                                                                    <a href="{{ route('library.book_assign.destroy', $n->id) }}" class="btn btn-danger btnDelete" onclick="confirm('Are you sure??')"><i class="fas fa-trash"></i></a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="returned">
                                    <div class="table-responsive">
                                        <table class="table text-center border border-1 table-striped">
                                            <caption class="caption text-center">Returned books</caption>
                                            <thead>
                                                <tr>
                                                    <th>S.L</th>
                                                    <th>Student's name</th>
                                                    <th>Book's name</th>
                                                    <th>Bookshelf</th>
                                                    <th>Total book</th>
                                                    <th>Assigned date</th>
                                                    <th>Return date</th>
                                                    <th>Returned date</th>
                                                    <th>Status</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                @forelse ($returned_info_all as $key => $n)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $n->student_name ?? '' }}</td>
                                                        <td>{{ $n->book_name ?? '' }}</td>
                                                        <td>{{ $n->bookshelf_name ?? '' }}</td>
                                                        <td>{{ $n->qty ?? '' }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->assign_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->return_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->returned_date)) }}</td>
                                                        <td>{{ $n->status}}</td>
                                                        <td>{{ $n->created_by }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->created_at)) }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="javascript:void(0)" class="btn btn-info btnView"
                                                                data-id="{{ $n->id }}"><i class="fas fa-eye"></i></a>
                                                                @if (Auth::user()->can('edit book-assign') || Auth::user()->role->id == 1)
                                                                    <a href="{{ route('library.book_assign.edit', $n->id) }}" class="btn btn-dark btnEdit" target="_blank"><i class="fas fa-edit"></i></a>
                                                                @endif
                                                                @if (Auth::user()->can('delete book-assign') || Auth::user()->role->id == 1)
                                                                    <a href="{{ route('library.book_assign.destroy', $n->id) }}" class="btn btn-danger btnDelete" onclick="confirm('Are you sure??')"><i class="fas fa-trash"></i></a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="return">
                                    <div class="table-responsive">
                                        <table class="table text-center border border-1 table-striped">
                                            <caption class="caption text-center">Delay</caption>
                                            <thead>
                                                <tr>
                                                    <th>S.L</th>
                                                    <th>Student's name</th>
                                                    <th>Book's name</th>
                                                    <th>Bookshelf</th>
                                                    <th>Total book</th>
                                                    <th>Assigned date</th>
                                                    <th>Return date</th>
                                                    <th>Status</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                @forelse ($delay_info_all as $key => $n)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $n->student_name ?? '' }}</td>
                                                        <td>{{ $n->book_name ?? '' }}</td>
                                                        <td>{{ $n->bookshelf_name ?? '' }}</td>
                                                        <td>{{ $n->qty ?? '' }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->assign_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->return_date)) }}</td>
                                                        <td>{{ $n->status }}</td>
                                                        <td>{{ $n->created_by }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->created_at)) }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="javascript:void(0)" class="btn btn-info btnView"
                                                                data-id="{{ $n->id }}"><i class="fas fa-eye"></i></a>
                                                                @if (Auth::user()->can('edit book-assign') || Auth::user()->role->id == 1)
                                                                    <a href="{{ route('library.book_assign.edit', $n->id) }}" class="btn btn-dark btnEdit" target="_blank"><i class="fas fa-edit"></i></a>
                                                                @endif
                                                                @if (Auth::user()->can('delete book-assign') || Auth::user()->role->id == 1)
                                                                    <a href="{{ route('library.book_assign.destroy', $n->id) }}" class="btn btn-danger btnDelete" onclick="confirm('Are you sure??')"><i class="fas fa-trash"></i></a>
                                                                @endif
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @empty
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
                        <table class="table table-borderless table-striped">
                            <tbody id="view-tbody">
                                <tr>
                                    <td>Student's Name</td>
                                    <td>
                                        <span id="view-std-name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Student's Phone</td>
                                    <td>
                                        <span id="view-std-phone"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Book's Name</td>
                                    <td>
                                        <span id="view-name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>
                                        <span id="view-cat"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Department's Name</td>
                                    <td>
                                        <span id="view-department"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Bookshelf</td>
                                    <td>
                                        <span id="view-bookshelf"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Quantity</td>
                                    <td>
                                        <span id="view-qty"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Assign date</td>
                                    <td>
                                        <span id="view-assign-date"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Return date</td>
                                    <td>
                                        <span id="view-return-date"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Returned date</td>
                                    <td>
                                        <span id="view-returned-date"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <span id="view-status"></span>
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
    <script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                autoclose: true,
            });

            $('#date').on('change', function() {
                let url = "{{ route('library.report.daily', ['date']) }}";
                url = url.replace('date', $(this).val());
                window.location = url;
            });


             //view-modal
             $('.btnView').click( function(){
                if($(this).data('id') != null || $(this).data('id') != ''){
                    let url = ("{{ route('library.book_assign.show', ['id']) }}");
                    let _url = url.replace('id', $(this).data('id'));
                    $.ajax({
                        url: _url,
                        method: "GET",
                        success: function (response) {
                            console.log(response)
                            $('#view-std-name').html(response.student.name);
                            $('#view-std-phone').html(response.student.phone);
                            $('#view-name').html(response.book.name);
                            $('#view-cat').html(response.book.category.name);
                            $('#view-department').html(response.book.category.department.department_name);
                            $('#view-bookshelf').html(response.book.bookshelf.name);
                            $('#view-qty').html(response.qty);
                            $('#view-assign-date').html(response.assign_date);
                            $('#view-return-date').html(response.return_date);
                            $('#view-returned-date').html(response.returned_date ?? '');
                            $('#view-status').html(response.status);
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
