@extends('layouts.app')

@section('title', '')

@push('third_party_stylesheets')

@endpush

@push('page_css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4></h4>
                    </span>
                    <span class="float-right">

                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('third_party_scripts')

@endpush

@push('page_scripts')
<script>

</script>
@endpush

