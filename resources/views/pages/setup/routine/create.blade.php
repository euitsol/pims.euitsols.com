@extends('layouts.app')

@section('title', 'Routine Management')

@push('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
@endpush

@push('page_css')
<style>
    .card-header::after, .card-body::after, .card-footer::after {
        content: unset;
    }
    .routine{
        border-bottom: 1px solid blue;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="">
                        <h6 class="mb-0">Routine</h6>
                    </div>
                    <div class="">
                        <a href="" class="btn btn-info">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-center">
                                Session: {{ $routine->session->start }}-{{ $routine->session->end }} |
                                Department: {{ $routine->department->department_name }} |
                                Semester: {{ $routine->semester->name }} |
                                Group: {{ $routine->group->name }} |
                                Shift: {{ $routine->shift->name }}
                            </h6>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 m-auto">
                                    <div id="calendar"></div>
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
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
@endpush

@push('page_scripts')
<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        header: {
            left:   '',
            center: '',
            right:  ''
        },
        initialView: 'timeGridWeek',
        weekNumbers:  false,
        allDaySlot: false,
        slotEventOverlap: false,
        slotDuration: '00:15:00',
        slotLabelFormat: {
            hour: 'numeric',
            minute: '2-digit',
            omitZeroMinute: true,
            meridiem: 'short'
        },
        slotMinTime:'06:00:00',
        slotMaxTime:'20:00:00',
        expandRows: true,


      });
      calendar.on('dateClick', function(info) {
        console.log('clicked on ' + info.dateStr);
      });
      calendar.render();
    });

  </script>
@endpush

