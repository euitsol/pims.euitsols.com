@extends('layouts.app')

@section('title', 'Create Exam')

@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">
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
                            <h4>Create Exam</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('em.create.show', $exam_search->id) }}" class="btn btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 m-auto">
                                <table class="table">
                                    <tr class="table-active">
                                        <td>Session</td>
                                        <td>:</td>
                                        <td>{{ $exam_search->session->start }} - {{ $exam_search->session->end }}</td>

                                        <td>Department</td>
                                        <td>:</td>
                                        <td>{{ $exam_search->department->department_name }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td>Semester</td>
                                        <td>:</td>
                                        <td>{{ $exam_search->semester->name }}</td>

                                        <td>Created By</td>
                                        <td>:</td>
                                        <td>{{ $exam_search->created_user->name }}</td>
                                    </tr>
                                </table>
                                <form action="{{ route('em.create.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="exam_search" value="{{ $exam_search->id }}">
                                    <div class="form-group row">
                                        <label class="col-sm-3 " for="exam_type"> Select Exam Type<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="exam_type" class="form-control select" id="exam_type" required>
                                                <option value="" hidden>Select Exam Type</option>
                                                @foreach ($exam_types as $exam_type)
                                                    <option value="{{ $exam_type->id }}"
                                                        @if (old('exam_type') == $exam_type->id) selected @endif
                                                        @if ($exam_type->search($exam_search->id)) @disabled(true) @endif>
                                                        {{ $exam_type->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('exam_type'))
                                                <span class="text-danger">{{ $errors->first('exam_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 " for="total_mark">Mark <small> per credit </small><span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control" name="total_mark"
                                                value="{{ old('total_mark') }}" id="total_mark" min="0.00"
                                                placeholder="Enter exam mark per credit" required>
                                            @if ($errors->has('total_mark'))
                                                <span class="text-danger">{{ $errors->first('total_mark') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3" for="exam_hour">Exam Duration <small> per credit
                                            </small><span class="text-danger">*</span></label>
                                        <div class="col-sm-9 d-flex">
                                            <input type="number" step="0.01" class="form-control" id="exam_hour"
                                                value="{{ old('exam_hour') }}" min="0.00"
                                                placeholder="Enter exam hour per credit" name="exam_hour" required>
                                            <div class="input-group-append">
                                                <select class="form-control" name="hour_minute" id="hour_minute" required>
                                                    <option value="1"
                                                        @if (old('hour_minute') == 1) selected @endif>Hours</option>
                                                    <option value="2"
                                                        @if (old('hour_minute') == 2) selected @endif>Minutes</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if ($errors->has('exam_hour'))
                                            <span class="text-danger ml-2">{{ $errors->first('exam_hour') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 " for="total_fee"> Total fee <small>in Tk</small></label>
                                        <div class="col-sm-9">
                                            <input type="number" step="1" min="0" class="form-control"
                                                name="total_fee" value="{{ old('total_fee') ?? 0 }}" id="total_fee"
                                                placeholder="Enter total fee for the exam" required>
                                            <small>Leave it "0" if there is no fee</small>
                                            @if ($errors->has('total_fee'))
                                                <span class="text-danger">{{ $errors->first('total_fee') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 "> Exam Schedule </label>
                                        <div class="col-sm-9">
                                            <div>
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th class="align-middle text-center">Shift</th>
                                                        <th class="align-middle text-center">Group</th>
                                                        <th class="align-middle text-center">Exam Shift</th>
                                                    </tr>
                                                    @foreach ($shifts as $shift)
                                                        @foreach ($groups as $group)
                                                            <tr>
                                                                <td class="align-middle text-center">{{ $shift->name }}
                                                                </td>
                                                                <td class="align-middle text-center">{{ $group->name }}
                                                                </td>
                                                                <td class="align-middle text-center">
                                                                    <input type="hidden"
                                                                        name="data[{{ $count }}][shift]"
                                                                        value="{{ $shift->id }}">
                                                                    <input type="hidden"
                                                                        name="data[{{ $count }}][group]"
                                                                        value="{{ $group->id }}">
                                                                    <select name="data[{{ $count }}][exam_shift]"
                                                                        class="form-control select" required>
                                                                        <option value="" hidden>Select Exam Shift
                                                                        </option>
                                                                        @foreach ($exam_shifts as $exam_shift)
                                                                            <option value="{{ $exam_shift->id }}"
                                                                                @if (old('exam_shift') == $exam_shift->id) selected @endif>
                                                                                {{ $exam_shift->name }} | Starts:
                                                                                {{ date('h:i A', strtotime($exam_shift->start)) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('exam_shift'))
                                                                        <span
                                                                            class="text-danger">{{ $errors->first('exam_shift') }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $count++;
                                                            @endphp
                                                        @endforeach
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 "> Select Subject </label>
                                        <div class="col-sm-9">
                                            @forelse ($subjects as $key => $subject)
                                                <table class="table table-striped">
                                                    <tr>
                                                        <td class="align-middle text-left">
                                                            <input class="" type="checkbox"
                                                                name="subjects[{{ $key }}][subject_id]"
                                                                value="{{ $subject->subject->id }}"
                                                                id="check_{{ $subject->id }}"
                                                                style="width: 25px; height: 25px;"
                                                                data-id="{{ $subject->id }}">
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <label class="ml-2" for="check_{{ $subject->id }}">
                                                                <span class="">{{ $subject->subject->name }}
                                                                    ({{ $subject->subject->code }})
                                                                    , Credit:
                                                                    {{ $subject->subject->credit->credit_number }} </span>
                                                            </label>
                                                        </td>
                                                        <td class="align-middle text-right">
                                                            <input type="text" id="exam_date_{{ $subject->id }}"
                                                                class="form-control date"
                                                                name="subjects[{{ $key }}][exam_date]"
                                                                placeholder="Enter exam date" disabled="disabled">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <span class="text-danger">Please select the subject(s)</span>
                                            @empty
                                                <span class="text-red">Please <a
                                                        href="{{ route('subject-assign.create') }}">assign subject</a>
                                                    first</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3" for="create"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary w-100" id="examCreateButton"
                                                disabled>Create</button>
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
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.select').select2();

            $('.date').datepicker({
                autoclose: true,
                format: "dd MM yyyy",
            });

            //Checkbox check make the input required
            $('input[type="checkbox"]').click(function() {
                if ($(this).prop("checked") == true) {
                    id = $(this).data('id');
                    $('#exam_date_' + id).attr('disabled', false);
                    $('#exam_date_' + id).focus();
                    $('#exam_date_' + id).attr('reqired', true);
                    $('#examCreateButton').attr('disabled', false);
                } else if ($(this).prop("checked") == false) {
                    $('#exam_date_' + id).attr('disabled', true);
                    $('#exam_date_' + id).val('');
                    $('#exam_date_' + id).attr('reqired', false);
                    $('#examCreateButton').attr('disabled', true);
                }
            });
        });
    </script>
@endpush
