@extends('layouts.app')

@section('title', 'Library Management - Add student')
@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush
@push('page_css')
    <style>

        /* .tab-content-bg{
            background: white;
        }
        .card-body {
            background-color: #f6f8fa;
        }
        */
       .card-body .nav a{
            background-color: #0c9fce;
            color: white !important;
        }
       .card-body .nav a:active{
            /* background-color: #0c9fce; */
            color: black !important;
        }
       .card-body .nav a:focus{
            /* background-color: #0c9fce; */
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
                        @if(Auth::user()->can('library-student view') || Auth::user()->role->id == 1)<a href="{{ route('library.student.index') }}" class="btn btn-info">Back</a>@endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="tab-parent p-4 level-1-page">
                        <ul class="nav nav-tabs">
                            <li class="nav-item mr-1 border border-bottom-0 rounded">
                                <a  class="nav-link active" data-toggle="tab" href="#student_div">Add a residential Students</a>
                            </li>
                            <li class="nav-item border border-bottom-0 rounded">
                                <a class="nav-link " data-toggle="tab" href="#non_student_div">Add a non-residential Students</a>
                            </li>
                        </ul>

                        <div class="tab-content tab-content-bg p-4 border border-top-0 shadow-sm rounded">
                            <div class="tab-pane active" id="student_div">
                                <form action="{{route('library.student.store')}}" method="POST">
                                    @csrf
                                    <div class="row mb-3" id="select_div">
                                            <div class="col-md-6 input-group m-auto">
                                                <select class="form-control select2" name="std_id" id="std_id">
                                                    <option value="" hidden>Select Student ID</option>
                                                    @foreach ($students as $student )
                                                        <option value="{{$student->studentInfo->id}}">{{$student->studentInfo->student_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>

                                </form>
                            </div>

                            <div class="tab-pane" id="non_student_div">
                                <form action="{{route('library.student.store')}}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="name">Name<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Enter student's name" required>
                                            @if($errors->has('name')) <span class="text-danger">{{$errors->first('name')}}</span> @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone">Phone<span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="phone" name="phone" placeholder="Enter student's phone" required>
                                            @if($errors->has('phone')) <span class="text-danger">{{$errors->first('phone')}}</span> @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="age">Age<span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="age" name="age" placeholder="Enter student's age">
                                            @if($errors->has('age')) <span class="text-danger">{{$errors->first('age')}}</span> @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="ec_name">Emergency contact (name)<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="ec_name" name="ec_name" placeholder="Enter student's emergency contact (name)">
                                            @if($errors->has('ec_name')) <span class="text-danger">{{$errors->first('ec_name')}}</span> @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label for="ec_phone">Emergency contact (phone)<span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="ec_phone" name="ec_phone" placeholder="Enter student's emergency contact (phone)">
                                            @if($errors->has('ec_phone')) <span class="text-danger">{{$errors->first('ec_phone')}}</span> @endif
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="present_add">Present address<span class="text-danger">*</span></label>
                                            <textarea name="present_add" class="form-control" id="present_add" cols="30" rows="6" placeholder="Enter student's present address"></textarea>
                                            @if($errors->has('present_add')) <span class="text-danger">{{$errors->first('present_add')}}</span> @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label for="permanent_add">Permanent address<span class="text-danger">*</span></label>
                                            <textarea name="permanent_add" class="form-control" id="permanent_add" cols="30" rows="6" placeholder="Enter student's parmanent address"></textarea>
                                            @if($errors->has('permanent_add')) <span class="text-danger">{{$errors->first('permanent_add')}}</span> @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="w-100">
                                            <button class="btn btn-info w-100">Save</button>
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
     {{-- Select2 --}}
     <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            //Single student fetch. to implement this just use one id that is #select_div use for the parent of select student id and try to avoid #select_div's next element
            $('#select_div').find('select').change(function(){
               let student_infos_id = $(this).val();
               if(std_id != ''){
                $.ajax({
                    type: "get",
                    url: "{{route('residentialStdShow')}}",
                    data: {
                        'id' : student_infos_id
                    },
                    success: function (response) {
                        console.log(response);

                        let dob = new Date(response.dob);
                        let today = new Date();
                        let age = today.getFullYear() - dob.getFullYear();
                        let student_info = `
                                        <div class="row mt-4 p-4" id='std_info'>
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
                                                                <input type='text' class='border-0 bg-transparent' name='name' value=' ${response.name}' readonly>
                                                            </td>
                                                            <td>
                                                                Student ID
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                               <input type='number' class='border-0 bg-transparent' name='std_id' value='${response.id}' readonly>
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
                                                                <input type='tel' class='border-0 bg-transparent' name='phone' value='${response.phone}' readonly>
                                                            </td>
                                                            <td>
                                                                Student Date of Birth
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='number' class='border-0 bg-transparent' style='width:22px;'  name='age' value='${age}' readonly>years
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
                                                                <input type='text' class='border-0 bg-transparent' name='present_add' value='${response.present_address}' readonly>

                                                            </td>
                                                            <td>
                                                                Parmanent Address
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                <input type='text' class='border-0 bg-transparent' name='permanent_add' value='${response.parmanent_address}' readonly>

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
                                                                 <input type='text' class='border-0 bg-transparent' name='ec_name' value='${response.father_name}' readonly>
                                                            </td>
                                                            <td>
                                                                Emergency Contact (Phone)
                                                            </td>
                                                            <td>
                                                                :
                                                            </td>
                                                            <td>
                                                                 <input type='tel' class='border-0 bg-transparent' name='ec_phone' value='${response.gardian_phone}' readonly>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row text-center mt-4" id="btn_div">
                                            <button class="btn btn-info w-100 m-auto">Save</button>
                                        </div> `;

                        $('#select_div').nextAll().remove();

                        $(student_info).insertAfter("#select_div");
                    }
                });
               }
            });


        });
    </script>
@endpush
