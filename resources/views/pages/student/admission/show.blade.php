@extends('layouts.app')

@section('title', 'Admitted student')

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
                        <h4>View {{$page_name}}</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('user add') || Auth::user()->role->id == 1)<a href="{{ route('student-admit.create') }}" class="btn btn-info">Admit a new Student</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    @include('partial.flush-message')

                    <div class="table table-responsive">
                        <table id="table" class="">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Department Name</th>
                                    <th>Student's Name</th>
                                    <th>Student's Phone</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->department->department_name ?? ''}}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->created_at)); }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->created_by)); }}</td>
                                        <td>
                                            <div class="btn-group">
                                                {{-- //view  --}}
                                                <a href="{{route('student-admit.show',$value->id)}}" class="btn btn-info btnView" data-id="{{ $value->id }}"><i class="fas fa-eye"></i></a>

                                                {{-- //edit  --}}
                                                @if(Auth::user()->can('Admission edit') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('student-admit.edit', $value->id) }}" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>
                                                @endif

                                                {{-- //delete  --}}
                                                @if(Auth::user()->can('Admission delete') || Auth::user()->role->id == 1)
                                                    <a href="{{ route('student-admit.destroy', $value->id) }}" class="btn btn-danger btnDelete "><i class="fas fa-trash"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
<div class="modal fade" id="view-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Details <span id="view-header"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-10 m-auto">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped">
                            <tbody id="view-tbody">

                                <tr>
                                    <td>Department Name</td>
                                    <td>
                                        <span id="departments_id"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Student Name</td>
                                    <td>
                                        <span id="name"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Father's Name</td>
                                    <td>
                                        <span id="father_name"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Mother's Name</td>
                                    <td>
                                        <span id="mother_name"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Present Address</td>
                                    <td>
                                        <span id="present_address"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Parmanent Address</td>
                                    <td>
                                        <span id="parmanent_address"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>
                                        <span id="email"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>
                                        <span id="phone"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gaurdian Phone</td>
                                    <td>
                                        <span id="gardian_phone"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>
                                        <span id="gender"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>
                                        <span id="dob"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nationality</td>
                                    <td>
                                        <span id="nationality"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Blood Group</td>
                                    <td>
                                        <span id="bg_id"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quota</td>
                                    <td>
                                        <span id="quota"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Division</td>
                                    <td>
                                        <span id="division_id"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>District</td>
                                    <td>
                                        <span id="district_id"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Photo</td>
                                    <td>
                                        <span id="photo"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Exam Name</td>
                                    <td>
                                        <span id="exam_id"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Passing Year</td>
                                    <td>
                                        <span id="passing_year"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Group</td>
                                    <td>
                                        <span id="group"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Board</td>
                                    <td>
                                        <span id="board_id"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Roll</td>
                                    <td>
                                        <span id="roll"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Registration Number</td>
                                    <td>
                                        <span id="reg_no"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>G.P.A</td>
                                    <td>
                                        <span id="gpa"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Registration Card</td>
                                    <td>
                                        <span id="reg_card"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Marksheet</td>
                                    <td>
                                        <span id="marksheet"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Applied At</td>
                                    <td>
                                        <span id="view-createdAt"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

    $('.btnView').click( function(){
            if($(this).data('id') != null || $(this).data('id') != ''){
                let url = ("{{ route('student-admit.show', ['id']) }}");
                let _url = url.replace('id', $(this).data('id'));
                $.ajax({
                    url: _url,
                    method: "GET",
                    success: function (response) {
                        console.log(response);

                        $('#departments_id').html(response.department_name);
                        $('#name').html(response.name);
                        $('#father_name').html(response.name);
                        $('#mother_name').html(response.name);
                        $('#present_address').html(response.name);
                        $('#parmanent_address').html(response.name);
                        $('#email').html(response.name);
                        $('#phone').html(response.name);
                        $('#gardian_phone').html(response.name);
                        $('#gender').html(response.name);
                        $('#dob').html(response.name);
                        $('#nationality').html(response.name);
                        $('#bg_id').html(response.name);
                        $('#quota').html(response.name);
                        $('#division_id').html(response.name);
                        $('#district_id').html(response.name);
                        $('#photo').html(response.name);
                        $('#view-createdAt').html(response.created_at ? new Date(response.created_at) : ''); $('#view-modal').modal('show');
                    }
                });
            }else{
                alart('Something went wrong');
            }
        });
});
</script>
@endpush
