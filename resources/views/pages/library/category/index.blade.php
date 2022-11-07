@extends('layouts.app')

@section('title', 'Library Management')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Category</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('add library-setup-category') || Auth::user()->role->id == 1)<a href="{{ route('library.setup.category.create') }}" class="btn btn-info">Add new category</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse ( $categories as $key=>$category)
                                   <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->created_user->name}}</td>
                                    <td>{{date('d-m-Y',strtotime($category->created_user->created_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if(Auth::user()->can('edit category') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.setup.category.edit', $category->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete category') || Auth::user()->role->id == 1)
                                                <a href="{{ route('library.setup.category.destroy', $category->id) }}" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                   </tr>
                                @empty
                                    <span>There are no categories</span>
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


