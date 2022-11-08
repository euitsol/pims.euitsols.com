@extends('layouts.app')

@section('title', 'Library Management - Add book')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Books</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add add-books') || Auth::user()->role->id == 1)<a href="{{ route('library.setup.add_book.create') }}" class="btn btn-info">Add new books</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Author's Name</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Bookshelf</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse ( $books as $key=>$book)
                                   <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$book->name}}</td>
                                    <td>{{$book->author_name}}</td>
                                    <td>{{$book->qty}}</td>
                                    <td>{{$book->category->name}}</td>
                                    <td>{{$book->bookshelf->name}}</td>
                                    <td>{{$book->created_user->name}}</td>
                                    <td>{{date('d-m-Y',strtotime($book->created_user->created_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-info btnView"
                                                        data-id="{{ $book->id }}"><i class="fas fa-eye"></i></a>
                                            @if(Auth::user()->can('edit book') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.setup.add_book.edit', $book->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete book') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.setup.add_book.destroy', $book->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                   </tr>
                                @empty
                                    <tr>
                                        <td colspan='9'><span>There are no books</span></td>
                                    </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


