@extends('layouts.app')

@section('title', 'Library Management - Edit Book')


@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit {{$book->name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('library-setup-category view') || Auth::user()->role->id == 1)<a href="{{ route('library.setup.book.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <form action="{{ route('library.setup.book.update') }}" method="POST" class="form-horizontal">
                                @csrf
                                <input type="hidden" name="id" value="{{$book->id}}">

                                <div class="form-group row">
                                    <label class="col-sm-3" for="name">Book's Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter Book's name" value="{{$book->name}}" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="author_name">Author's Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="author_name" id="author_name" value="{{$book->author_name}}" placeholder="Enter Author's name" required>
                                        @if ($errors->has('author_name'))
                                            <span class="text-danger">{{ $errors->first('author_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3" for="qty">Quantity<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="qty" id="qty" value="{{$book->qty}}" placeholder="Enter quantity" required>
                                        @if ($errors->has('qty'))
                                            <span class="text-danger">{{ $errors->first('qty') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3" for="category_id">Category<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="" hidden>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}" @if($book->category->id ==$category->id) selected @endif >{{$category->name}}</option>
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
                                        <select name="bookshelf_id" id="bookshelf_id" class="form-control" required >
                                            <option value="" hidden>Select Bookshelf</option>
                                            @foreach ($bookshelves as $bookshelf)
                                                <option value="{{$bookshelf->id}}" @if($book->category->id== $bookshelf->id) selected @endif >{{$bookshelf->name}}</option>
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
                                        <button type="submit" class="btn btn-primary w-100">Update</button>
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

