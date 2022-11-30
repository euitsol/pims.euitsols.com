@extends('layouts.app')

@section('title', 'Library Management - Add Member')
@push('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/Datepicker/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush
@push('page_css')
    <style>
       .card-body .nav a{
            background-color: #0c9fce;
            color: white !important;
        }
       .card-body .nav a:active{
            color: black !important;
        }
       .card-body .nav a:focus{
            color: black !important;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            color: #495057 !important;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

    </style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add new student</h4>
                    </span>
                    <span class="float-right">
                        @if(Auth::user()->can('library-student view') || Auth::user()->role->id == 1)<a href="{{ route('library.member.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="tab-parent p-4 level-1-page">
                        <ul class="nav nav-tabs">
                            <li class="nav-item mr-1 border border-bottom-0 rounded">
                                <a  class="nav-link active" data-toggle="tab" href="#student_div">Add a residential Student</a>
                            </li>
                            <li class="nav-item mr-1 border border-bottom-0 rounded">
                                <a  class="nav-link" data-toggle="tab" href="#teacher_div">Add a residential Teacher</a>
                            </li>
                            <li class="nav-item border border-bottom-0 rounded">
                                <a class="nav-link " data-toggle="tab" href="#non_student_div">Add a non-residential Member</a>
                            </li>
                        </ul>

                        <div class="tab-content tab-content-bg p-4 border border-top-0 shadow-sm rounded">
                            <div class="tab-pane active" id="student_div">
                                <form action="{{route('library.member.store')}}" method="POST">
                                    @csrf
                                    <div class="row mb-3" id="select_div">
                                        <div class="col-md-6 input-group m-auto">
                                            <select class="form-control select2" name="std_id" id="std_id">
                                                <option value="" hidden >Select Student ID</option>
                                                @foreach ($students as $student )
                                                    <option value="{{$student->studentInfo->id}}" @if($student->studentInfo->stdCheck()) disabled @endif>{{$student->studentInfo->student_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                <div class="row mt-4 p-4" id='std_info'>

                                </div>
                                <div class="row text-center mt-4" id="btn_div">
                                    <button type="button" class="save-btn btn btn-info w-100 m-auto">Save</button>
                                </div>

                                </form>
                            </div>

                            <div class="tab-pane" id="teacher_div">
                                <form action="{{route('library.member.store')}}" method="POST">
                                    @csrf
                                    <div class="row mb-3" id="select_div">
                                            <div class="col-md-6 input-group m-auto">
                                                <select class="form-control select2" name="teacher_id" id="teacher_id">
                                                    <option value="" hidden >Select Teacher ID</option>
                                                    @foreach ($teachers as $teacher )
                                                        <option value="{{$teacher->id}}" @if($teacher->teacherCheck()) disabled @endif>{{$teacher->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>
                                    <div class="row mt-4 p-4">

                                    </div>
                                    <div class="row text-center mt-4" id="btn_div">
                                        <button type="button" class="save-btn btn btn-info w-100 m-auto">Save</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="non_student_div">
                                <form action="{{route('library.member.store')}}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="name">Name<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Enter student's name" required>
                                            @if($errors->has('name')) <span class="text-danger">{{$errors->first('name')}}</span> @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone">Phone<span class="text-danger">*</span></label>
                                            <input class="form-control" type="tel" id="phone" name="phone" placeholder="Enter student's phone" required>
                                            @if($errors->has('phone')) <span class="text-danger">{{$errors->first('phone')}}</span> @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dob">Date of Birth<span class="text-danger">*</span></label>
                                            <input class="form-control date" type="text" id="dob" name="dob" placeholder="Enter student's date of birth" required>
                                            @if($errors->has('dob')) <span class="text-danger">{{$errors->first('dob')}}</span> @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="member_id">Member ID</label>
                                            <input class="form-control" type="text" id="member_id2" name="member_id" placeholder="Enter member ID">
                                            <span class="btn btn-info" id="generate_id">Generate ID</span>
                                            @if($errors->has('member_id')) <span class="text-danger">{{$errors->first('member_id')}}</span> @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ec_name">Emergency contact (name)</label>
                                            <input class="form-control" type="text" id="ec_name" name="ec_name" placeholder="Enter student's emergency contact (name)">
                                            @if($errors->has('ec_name')) <span class="text-danger">{{$errors->first('ec_name')}}</span> @endif
                                        </div>

                                        <div class="col-md-4">
                                            <label for="ec_phone">Emergency contact (phone)</label>
                                            <input class="form-control" type="tel" id="ec_phone" name="ec_phone" placeholder="Enter student's emergency contact (phone)">
                                            @if($errors->has('ec_phone')) <span class="text-danger">{{$errors->first('ec_phone')}}</span> @endif
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="present_add">Present address<span class="text-danger">*</span></label>
                                            <textarea name="present_add" class="form-control" id="present_add" cols="30" rows="6" placeholder="Enter student's present address" required></textarea>
                                            @if($errors->has('present_add')) <span class="text-danger">{{$errors->first('present_add')}}</span> @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label for="permanent_add">Permanent address<span class="text-danger">*</span></label>
                                            <textarea name="permanent_add" class="form-control" id="permanent_add" cols="30" rows="6" placeholder="Enter student's parmanent address" required></textarea>
                                            @if($errors->has('permanent_add')) <span class="text-danger">{{$errors->first('permanent_add')}}</span> @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="w-100">
                                            <button type="button" class="save-btn btn btn-info w-100">Save</button>
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
</div>
@endsection

@push('third_party_scripts')
{{-- //datpicker --}}
<script src="{{ asset('assets/js/Datepicker/datepicker.min.js') }}"></script>
     {{-- Select2 --}}
     <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                autoclose: true,
            });

            $('.select2').select2();

            $("#generate_id").on('click',function(){
                $(this).prev().val("{{$member_id ?? ''}}")
            });

            //submit button
            $('.save-btn').on('click',function(e){
               let index = $('.save-btn').index($(this));
               let member_id = $('#member_id'+index).val();

               if(member_id){
                $.ajax({
                    type:'get',
                    url:"{{route('library.member.id_check')}}",
                    data:{'member_id':member_id},
                    success:function(response){
                        $('#member_id'+index).next('span').remove();
                        if(response){
                            $('.save-btn').eq(index).prop('type','button');
                            $("<span class='text-danger'>This ID is taken.Try another</span>").insertAfter($('#member_id'+index))
                        }
                        else{
                            $('.save-btn').eq(index).prop('type','submit');
                        }
                    }
                });
               }
            })
            //Single student fetch. to implement this just use one id that is #select_div use for the parent of select student id and try to avoid #select_div's next element
            $('#select_div').find('select').change(function(){
               let student_infos_id = $(this).val();
               if(student_infos_id != ''){
                $.ajax({
                    type: "get",
                    url: "{{route('residential.std.fetch')}}",
                    data: {
                        'id' : student_infos_id
                    },
                    success: function (response) {
                        // console.log(response);
                        let student_info = `
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                Student's name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='name' value='${response.name}'>
                                                            </td>
                                                            <td>
                                                                Member ID
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                               <input type='number' name='member_id' id='member_id0' value='${response.student_id}'>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Student Phone
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='tel' name='phone' value='${response.phone}'>
                                                            </td>
                                                            <td>
                                                                Student Date of Birth
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='dob' value='${response.dob}'>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                Present Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='present_add' value='${response.present_address}'>

                                                            </td>
                                                            <td>
                                                                Permanent Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='permanent_add' value='${response.parmanent_address}'>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Emergency Contact (Name)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                 <input type='text' name='ec_name' value='${response.father_name}'>
                                                            </td>
                                                            <td>
                                                                Emergency Contact (Phone)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                 <input type='tel' name='ec_phone' value='${response.gardian_phone}'>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                       `;

                        $('#select_div').next('.row').html(student_info);
                    }
                });
               }else{
                $('#select_div').next('.row').html('');
               }
            });

            $('#teacher_id').on('change',function(){
               let teacher_id = $(this).val();
               if(teacher_id){
                   teacherChange(teacher_id);
               }else{
                $('#teacher_id').parent().parent().next('.row').html('');
               }
            })

        });
        function teacherChange(teacher_id){
            $.ajax({
                    type: "get",
                    url: "{{route('residential.teacher.fetch')}}",
                    data: {
                        'id' : teacher_id
                    },
                    success: function (response) {
                        let teacher_info = `
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                Teacher's name
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='name' value='${response.name ?? ''}'>
                                                            </td>
                                                            <td>
                                                                Member ID
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                               <input type='number' name='member_id' id='member_id1' value="{{$member_id ?? ''}}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Teacher Phone
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='tel' name='phone' value='${response.phone ?? ''}'>
                                                            </td>
                                                            <td>
                                                                Teacher Date of Birth
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='dob' value='${response.date_of_birth ?? ''}'>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                Present Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='present_add' value='${response.present_address ?? ''}'>

                                                            </td>
                                                            <td>
                                                                Permanent Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' name='permanent_add' value='${response.permanant_address ?? ''}'>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Emergency Contact (Name)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                 <input type='text' name='ec_name' value='${response.father_name ?? ''}'>
                                                            </td>
                                                            <td>
                                                                Emergency Contact (Phone)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                 <input type='tel' name='ec_phone' value='${response.gardian_phone ?? ''}'>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        `;

                        $('#teacher_id').parent().parent().next('.row').html(teacher_info);
                    }
                });
        }
    </script>
@endpush
