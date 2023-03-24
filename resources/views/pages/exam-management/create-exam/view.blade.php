@extends('layouts.app')

@section('title', 'Create Exam')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@section('content')
@php
    $count = 0;
@endphp
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>View Exam Details</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('em.create.show', $exam_create->search->id) }}" class="btn btn-info">Back</a>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">

                            <div class="table-responsive">
                                <table class="table table-borderless table-striped">
                                    <tbody id="view-tbody">
                                        <tr>
                                            <td>Exam Type</td>
                                            <td>:</td>
                                            <td>
                                                {{ $exam_create->type->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Fee</td>
                                            <td>:</td>
                                            <td>
                                                {{ $exam_create->total_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Created at</td>
                                            <td>:</td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($exam_create->created_at)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Created by</td>
                                            <td>:</td>
                                            <td>
                                                {{ $exam_create->created_user->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Updated at</td>
                                            <td>:</td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($exam_create->created_at)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Updated by</td>
                                            <td>:</td>
                                            <td>
                                                {{ optional($exam_create->updated_user)->name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-striped">
                                <tr>
                                    <td>Session</td>
                                    <td>:</td>
                                    <td>{{ $exam_create->search->session->start }} - {{ $exam_create->search->session->end }}</td>
                                </tr>
                                <tr>
                                    <td>Department</td>
                                    <td>:</td>
                                    <td>{{ $exam_create->search->department->department_name }}</td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>{{ $exam_create->search->semester->name }}</td>
                                </tr>
                                <tr>
                                    <td>Created By</td>
                                    <td>:</td>
                                    <td>{{ $exam_create->search->created_user->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-2 mb-2 col-md-12">
                            <table class="table table-striped"><tr><th class="text-center">Search to view subjects</th></tr></table>
                        </div>
                        <div class="col-md-12">
                            <form action="#" id="exam_routine">
                            @csrf
                            <input type="hidden" id="create_id" name="create_id" value="{{ $exam_create->id }}">
                            <input type="hidden" id="type_id" name="type_id" value="{{ $exam_create->type->id }}">
                            <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="shift_id">Shift</label>
                                    <select name="shift_id" class="form-control select" id="shift_id" required>
                                        <option value="" hidden>Select Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"
                                                @if (old('shift_id') == $shift->id) selected @endif>
                                                {{ $shift->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="group_id">Group</label>
                                    <select name="group_id" class="form-control select" id="group_id" required>
                                        <option value="" hidden>Select Group</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}"
                                                @if (old('group_id') == $group->id) selected @endif>
                                                {{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">&nbsp</label>
                                    <input id="submit" class="btn btn-success w-100" type="submit" name="submit" value="Search">
                                </div>
                            </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 routine_div" style="display: none" >
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Exam Routine</h3>
                                    <div class="card-tools">

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-center align-middle">
                                            <div class="text-center">
                                                <h4>{{ $exam_create->search->department->department_name }} ( {{ $exam_create->search->department->short_name }} )</h3>
                                                <h5>{{ $exam_create->type->name }} - {{ $exam_create->year }}</h4>
                                                <h5>
                                                    Session: {{ $exam_create->search->session->start }} - {{ $exam_create->search->session->end }},
                                                    Semester: {{ $exam_create->search->semester->name }},
                                                </h5>
                                                <h5>
                                                    Group: <span id="group_name"></span>,
                                                    Shift: <span id="shift_name"></span>,
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-stripeed" id="routine_table">

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.select').select2();


            $('#exam_routine').on('submit', function (e) {
                e.preventDefault();
                if ($('#group_id').val() != null || $('#shift_id').val() != null) {
                    let url = "{{ route('em.create.get_routine') }}";
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(response){
                            console.log(response);

                            let table_header='';
                            let table_body = '';

                            $(this).trigger("reset");
                            $('.routine_div').show();
                            $('#group_name').html(response.exam_schedules.group.name);
                            $('#shift_name').html(response.exam_schedules.shift.name);
                            table_header = `
                                <tr>
                                    <th>Date</th>
                                    <th>Subject</th>
                                    <th>Time</th>
                                    <th>Room</th>
                                </tr>
                            `;

                            $.each(response.exam_subjects, function( index, value ) {
                                table_body += `
                                    <tr>
                                        <td></td>
                                        <td>${value.subject.name}</td>
                                        <td>${response.exam_schedules.exam_shift.name} (${time_24_to_12(response.exam_schedules.exam_shift.start)} )</td>
                                        <td></td>
                                    </tr>
                                `;

                            });

                            $('#routine_table').html(table_header+table_body);


                        },
                        error: function(response) {
                            console.log(response);
                            $('.routine_div').hide();
                        }
                    });
                } else {
                    alert('Something went wrong');
                }
            });
        });

        function convertTime12To24(time) {
            var hours   = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);
            var AMPM    = time.match(/\s(.*)$/)[1];
            if (AMPM === "PM" && hours < 12) hours = hours + 12;
            if (AMPM === "AM" && hours === 12) hours = hours - 12;
            var sHours   = hours.toString();
            var sMinutes = minutes.toString();
            if (hours < 10) sHours = "0" + sHours;
            if (minutes < 10) sMinutes = "0" + sMinutes;
            return (sHours + ":" + sMinutes);
        }
    </script>
@endpush
