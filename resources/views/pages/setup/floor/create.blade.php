@extends('layouts.app')

@section('title', 'Floor Management')

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
                            <h4>{{ $building->name }}</h4>
                            <h4>1<sup>st</sup> floor</h4>
                        </span>
                        <span class="float-right">
                            <input type="number" id="class_room" class="from-control border-primary" step="1"
                                placeholder="Enter Total class room">
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="row row-cols-3" id="append">
                            </div>

                        </form>
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
        $(document).ready(function() {
            $('#class_room').keyup(function() {

                var individual_room = `
                                <div class="col shadow border rounded p-3 individual_room">
                                    <input type="number" class="form-control mb-2" placeholder="Enter class room number">
                                    <textarea name="details" class="form-control" cols="10" rows="3" placeholder="Enter class room's details"></textarea>
                                </div>
                                `;
                var room_number = $(this).val();

                if(room_number >0){
                    $('#append .individual_room,.submit-btn').remove();
                    console.log('remove');
                    for (i = 1; i <= room_number; i++) {
                    $('#append').append(individual_room);
                }

                //Subbimt button add
                $('#append').append(`<div class="col-12">
                                <button class="btn btn-primary w-100 mt-2 submit-btn">Submit</button>
                            </div>`);
                }

            });
        });
    </script>
@endpush
