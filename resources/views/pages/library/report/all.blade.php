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
                                        <label for="user">Users</label>
                                    </div>

                                    <div class="col-md-6 text-left mt-2">
                                        <select name="user_id" id="user" class="form-control">
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
                                    <a class="nav-link active " data-toggle="tab" href="#assign">Assigned books</a>
                                </li>
                                <li class="nav-item border ml-1 border-bottom-0">
                                    <a href="#returned" class="nav-link " data-toggle="tab">Returned books</a>
                                </li>
                                <li class="nav-item border ml-1 border-bottom-0">
                                    <a href="#return" class="nav-link" data-toggle="tab">Delay</a>
                                </li>
                            </ul>
                            {{-- </div> --}}
                            <div class="tab-content p-4 border border-top-0 shadow-sm">
                                <div class="tab-pane active" id="assign">
                                    <div class="table-responsive">
                                        <table class="table text-center border border-1 table-striped">
                                            <caption class="caption text-center">Assigned books</caption>
                                            <thead>
                                                <tr>
                                                    <th>S.L</th>
                                                    <th>Student's name</th>
                                                    <th>Student's phone</th>
                                                    <th>Book's name</th>
                                                    <th>Category</th>
                                                    <th>Bookshelf</th>
                                                    <th>Total book</th>
                                                    <th>Assigned date</th>
                                                    <th>Return date</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                @forelse ($assigned_info_all as $key => $n)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $n->student->name ?? '' }}</td>
                                                        <td>{{ $n->student->phone ?? '' }}</td>
                                                        <td>{{ $n->book->name ?? '' }}</td>
                                                        <td>{{ $n->book->category->name ?? '' }}</td>
                                                        <td>{{ $n->book->bookshelf->name ?? '' }}</td>
                                                        <td>{{ $n->qty ?? '' }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->assign_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->return_date)) }}</td>
                                                        <td>{{ $n->created_user->name }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->created_user->created_at)) }}
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
                                                    <th>Student's phone</th>
                                                    <th>Book's name</th>
                                                    <th>Category</th>
                                                    <th>Bookshelf</th>
                                                    <th>Total book</th>
                                                    <th>Assigned date</th>
                                                    <th>Return date</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                @forelse ($returned_info_all as $key => $n)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $n->student->name ?? '' }}</td>
                                                        <td>{{ $n->student->phone ?? '' }}</td>
                                                        <td>{{ $n->book->name ?? '' }}</td>
                                                        <td>{{ $n->book->category->name ?? '' }}</td>
                                                        <td>{{ $n->book->bookshelf->name ?? '' }}</td>
                                                        <td>{{ $n->qty ?? '' }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->assign_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->return_date)) }}</td>
                                                        <td>{{ $n->created_user->name }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->created_user->created_at)) }}
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
                                                    <th>Student's phone</th>
                                                    <th>Book's name</th>
                                                    <th>Category</th>
                                                    <th>Bookshelf</th>
                                                    <th>Total book</th>
                                                    <th>Assigned date</th>
                                                    <th>Return date</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                @forelse ($delay_info_all as $key => $n)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $n->student->name ?? '' }}</td>
                                                        <td>{{ $n->student->phone ?? '' }}</td>
                                                        <td>{{ $n->book->name ?? '' }}</td>
                                                        <td>{{ $n->book->category->name ?? '' }}</td>
                                                        <td>{{ $n->book->bookshelf->name ?? '' }}</td>
                                                        <td>{{ $n->qty ?? '' }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->assign_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->return_date)) }}</td>
                                                        <td>{{ $n->created_user->name }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($n->created_user->created_at)) }}
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
        });
    </script>
@endpush
