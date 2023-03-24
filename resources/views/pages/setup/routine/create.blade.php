@extends('layouts.app')

@section('title', 'Routine Management')

@push('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('page_css')
<style>
    .card-header::after,
    .card-body::after,
    .card-footer::after {
        content: unset;
    }

    .routine {
        border-bottom: 1px solid blue;
    }
    .fc-header-toolbar.fc-toolbar{
        display: none;
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
                        <a href="{{url('setup/routine/view')}}" class="btn btn-info">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Subjects</h3>
                                        </div>
                                        <div class="card-body p-0" style="display: block;">
                                            <ul class="nav nav-pills flex-column" id="subjects">
                                                @foreach ($routine->get_subjects() as $subject)
                                                <li class="nav-item">
                                                    <span class="btn btn-info subject" style="width: 100%" data-duration="{{ $subject->subject->duration() }}" data-name="{{ $subject->subject->code }}" data-id="{{ $subject->subject->id }}">{{ $subject->subject->name }} - {{ $subject->subject->code }} ({{ $subject->subject->duration() }})</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-striped">
                                            <tbody id="view-tbody">
                                                <tr>
                                                    <td>Session</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{{ $routine->session->start }} - {{ $routine->session->end }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Department</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{{ $routine->department->department_name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Semester</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{{ $routine->semester->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Shift</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{{ $routine->shift->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Group</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{{ $routine->group->name }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12 m-auto" style="height: 80vh">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endpush

@push('page_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var containerEl = document.getElementById('subjects');

      var Draggable = FullCalendar.Draggable;

      var calendar = new FullCalendar.Calendar(calendarEl, {
        height: '100%',
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
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        eventOverlap: false,


        eventDrop: function (event, delta) {
            console.log(event);
        },


        eventReceive: function (event, delta) {
            console.log(event)
        },

      });

      new Draggable(containerEl, {
        itemSelector: '.subject',
        eventData: function(eventEl) {
            return {
                title: eventEl.dataset.name,
                duration: eventEl.dataset.duration,
                extendedProps: {
                    id: eventEl.dataset.id,
                },
                durationEditable:false,
            };
        },
        durationEditable: false,
      });

      calendar.render();
    });



    $(document).ready(function() {
        $('#calendar .fc-col-header .fc-col-header-cell a').each( function() {
            let ret = $(this).html().split(" ");
            $(this).html(ret[0]);
        });

        toastr.success('Are you the 6 fingered man?')
    });

</script>
@endpush
