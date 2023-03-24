@extends('layouts.app')

@section('title', 'View students according to semester')

@push('third_party_stylesheets')
<link href="{{ asset('assets/js/DataTable/datatables.min.css') }}" rel="stylesheet">
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
                        <h4>View students from {{$minfo->name}}</h4>
                    </span>
                </div>
                <div class="card-body">
                    <form action="">
                        @csrf
                        <input type="hidden" name="semester_id" value="{{$minfo->id}}">
                        <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="session_id">Session</label>
                                <select name="session_id" class="form-control" id="session_id">
                                    <option value="" hidden>Select Session</option>
                                    <option value="">All</option>
                                    @foreach ($session as $n)
                                        <option value="{{ $n->id }}" @if(old('session_id') ==$n->id) selected @endif >{{ $n->start.'-'.$n->end }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('session_id'))
                                    <span class="text-danger">{{ $errors->first('session_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="group_id">Group</label>
                                <select name="group_id" id="group_id" class="form-control"
                                    style="width: 100%;" >
                                    <option value="" hidden>Select Group</option>
                                    <option value="">All</option>
                                    @foreach ($group as $n)
                                        <option value="{{ $n->id }}" @if(old('group_id') ==$n->id) selected @endif>{{ $n->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('group_id'))
                                    <span class="text-danger">{{ $errors->first('group_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="shift_id">Shift</label>
                                <select name="shift_id" id="shift_id" class="form-control"
                                    style="width: 100%;">
                                    <option value="" hidden>Select Shift</option>
                                    <option value="">All</option>
                                    @foreach ($shift as $n)
                                        <option value="{{ $n->id }}" @if(old('shift_id') ==$n->id) selected @endif>{{ $n->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('shift_id'))
                                    <span class="text-danger">{{ $errors->first('shift_id') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    </form>
                    <div class="table table-responsive">
                        <table id="table" class="">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Session</th>
                                    <th>Department</th>
                                    <th>Group</th>
                                    <th>Shift</th>
                                    <th>Student ID</th>
                                    <th>Student's Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach ($minfo->admittedStdAssign  as $key=> $value1)

                                    <tr>
                                       <td>{{ $key + 1 }}</td>
                                       <td>{{ $value1->session->start.'-'.$value1->session->end }}</td>
                                       <td>{{ $value1->studentInfo->department->department_name}}</td>
                                       <td>{{ $value1->group->name }}</td>
                                       <td>{{ $value1->shift->name }}</td>
                                       <td>{{ $value1->studentInfo->student_id }}</td>
                                       <td>{{ $value1->studentInfo->name }}</td>
                                       <td>{{ date('d-m-Y', strtotime($value1->studentInfo->created_at)); }}</td>
                                       <td>
                                           <div class="btn-group">

                                               {{-- //view  --}}
                                               <a href="{{route('student.show',$value1->studentInfo->id)}}" target="_blank" class="btn btn-info btnView"><i class="fas fa-eye"></i></a>

                                               {{-- //edit  --}}
                                               <a href="{{ route('student.student-admit.edit', $value1->studentInfo->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>

                                               {{-- //delete  --}}
                                               <a href="{{ route('student.admitted.destroy', $value1->id) }}" class="btn btn-danger btnDelete" title="Delete"><i class="fas fa-trash"></i></a>

                                           </div>
                                       </td>

                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('third_party_scripts')
<script src="{{ asset('assets/js/DataTable/datatables.min.js') }}"></script>
@endpush

@push('page_scripts')
<script>
$(document).ready(function() {
    $('#table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                title: 'User Management',
                download: 'open',
                orientation: 'potrait',
                pagesize: 'LETTER',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            }, 'pageLength'
        ]
    });
});

$("#session_id, #group_id,#shift_id").change(function(){
    var session_id = $('#session_id').val();
    var department_id = $('#department_id').val();
    var semester_id = "{{$minfo->id}}"
    var group_id = $('#group_id').val();
    var shift_id = $('#shift_id').val();
    // console.log(session_id,department_id,semester_id,group_id,shift_id)
    $.ajax({
        url:"{{route('student.ajax')}}",
        method:'GET',
        data:{
            session_id:session_id,
            department_id:department_id,
            semester_id:semester_id,
            group_id:group_id,
            shift_id:shift_id,
        },
            success:function(response){
            var tr = '';
            $.each(response,function(index,value){
                var show_url = "{{route('student.show','id')}}";
                var show_route = show_url.replace('id',value.student_info.id)

                var edit_url = "{{route('student.student-admit.edit','id')}}";
                var edit_route = edit_url.replace('id',value.student_info.id)

                var destroy_url = "{{route('student.admitted.destroy','id')}}";
                var destroy_route = destroy_url.replace('id',value.id)
                 tr += `<tr>
                            <td>${index+1}</td>
                            <td>${value.session.start+'-'+value.session.start }</td>
                            <td>${value.departments.department_name}</td>
                            <td>${value.group.name }</td>
                            <td>${value.shift.name }</td>
                            <td>${value.student_info.student_id }</td>
                            <td>${value.student_info.name }</td>
                            <td>${ value.student_info.created_at }</td>
                            <td>
                                <div class="btn-group">
                                    {{-- //view  --}}
                                    <a href="${show_route}" target="_blank" class="btn btn-info btnView"><i class="fas fa-eye"></i></a>

                                    {{-- //edit  --}}
                                    <a href="${edit_route}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>

                                    {{-- //delete  --}}
                                    <a href="${destroy_route}" class="btn btn-danger btnDelete" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                         </tr>
                        `;
            });
            $('#tbody').html(tr);
        }
    });

});
</script>
@endpush
