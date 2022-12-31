@extends('layouts.app')

@section('title', 'Library Management - Add Book')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush
@push('page_css')
<style>
    .qty-text{
        display: inherit;
    }
</style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add new book</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('book view') || Auth::user()->role->id == 1)<a href="{{ route('library.setup.book.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('library.setup.book.store') }}" method="POST" class="form-horizontal">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter book's name" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="author_name">Author's Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="author_name" id="author_name" value="{{ old('author_name') }}"  placeholder="Enter Author's name" required>
                                        @if ($errors->has('author_name'))
                                            <span class="text-danger">{{ $errors->first('author_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="qty">Quantity<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="qty" id="qty" value="{{ old('qty') }}" placeholder="Enter quantity" required>
                                        <span class="text-danger ml-1 qty-text"></span>
                                        @if ($errors->has('qty'))
                                            <span class="text-danger">{{ $errors->first('qty') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="category_id">Category<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="category_id" id="category_id" class="form-control select2" required>
                                            <option value="" hidden>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}" @if(old('category_id') ==$category->id) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="bookshelf_id">Bookshelf<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="bookshelf_id" id="bookshelf_id" class="form-control select2" required >
                                            <option value="" hidden>Select Bookshelf</option>
                                            @foreach ($bookshelves as $bookshelf)
                                                <option value="{{$bookshelf->id}}" @if(old('bookshelf_id') == $bookshelf->id) selected @endif >{{$bookshelf->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('bookshelf_id'))
                                            <span class="text-danger">{{ $errors->first('bookshelf_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="create"></label>
                                    <div class="col-sm-9">
                                        <button type="button" id="submit_btn" class="btn btn-primary w-100">Create</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
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

            $('#bookshelf_id').on('change',function(){
                let id = $(this).val();
                let book_qty = $('#qty').val();
                let url = "{{ route('library.setup.book.qty_check')}}"
                $('#qty').next('span').html('');
                if(book_qty){
                    $.ajax({
                    type: 'get',
                    url: url,
                    data:{'id':id,'book_qty': book_qty},
                    success: function(response){
                        console.log(response);
                        $('#submit_btn').attr('type','submit');
                       if(response){
                           $('#qty').next('span').html('Book quantity more than bookshelf capacity');
                           $('#submit_btn').attr('type','button');
                       }
                    }
                });
                }else{
                    console.log('Please fill up qantity')
                    $('#qty').next('span').html('Please, fill up quantity');
                }
            });
        });
    </script>
@endpush
