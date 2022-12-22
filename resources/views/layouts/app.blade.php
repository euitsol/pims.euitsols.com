<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title> @yield('title', 'Polytechnic Information Managenment System') - Polytechnic Information Managenment System </title>

    <!-- Favicon-->
    <link rel="icon" href="" type="image/png">

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom/table.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/toastr/toastr.min.css') }}" rel="stylesheet">
    @stack('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    @include('partial.nav')
    <!-- Left side column. contains the logo and sidebar -->
    @include('partial.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  py-5 px-5">
        @yield('content')
    </div>

    <!-- Main Footer -->
    @include('partial.footer')
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('assets/js/custom-functions.js') }}"></script>
@stack('third_party_scripts')

<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/css/toastr/toastr.min.js') }}"></script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

     //Ajax Data fetch according to  department
     function ajaxDataFetch(collect_data_arr, model, with_arr,returnFunc=null, append_element=null, old_value = null, belongs_to, has_many = null, coloum='name') {
            let data_arr = {};
            for (let selector in collect_data_arr) {
                let value_fatch = collect_data_arr[selector].split('-');
                data_arr[value_fatch[0]] = $('#' + collect_data_arr[selector]).val();
            }

            $.ajax({
                url: "{{ route('asset.product_fetch.ajax') }}",
                method: 'GET',
                async: false,
                data: {
                    'arr': data_arr,
                    'model': model,
                    'with_arr': with_arr,
                },
                success: function(response) {
                    if(returnFunc){
                        returnFunc(response)
                    }

                    if(response)
                    {
                        if(response.length>0){
                            if(append_element){
                                let option = "<option value='' hidden>Select...</option>";
                                $.each(response, function(index, value) {
                                    if (value[has_many]) {
                                        $.each(value[has_many], function(has_index, has_value) {
                                            if (has_value[belongs_to]) {
                                                option += `<option value="${has_value[belongs_to].id}" ${old_value == has_value[belongs_to].id ? 'selected' : ''}>${has_value[belongs_to][coloum]}</option>`;
                                            } else {
                                                option += `<option value="${has_value.id}" ${old_value == has_value.id ? 'selected' : ''}>${has_value[coloum]}</option>`;
                                            }
                                        });
                                    }
                                    else if(value[belongs_to]){
                                        if(value[belongs_to][has_many]){
                                            $.each(value[belongs_to][has_many], function(belongs_index,belongs_value) {
                                                option += `<option value="${belongs_value.id}" ${old_value == belongs_value.id ? 'selected' : ''}>${belongs_value[coloum]}</option>`;
                                            });
                                        } else {
                                                option += `<option value="${value[belongs_to].id}" ${old_value == value[belongs_to].id ? 'selected' : ''}>${value[belongs_to][coloum]}</option>`;
                                            }
                                    }
                                    else {
                                        option += `<option value="${value.id}" ${old_value == value.id ? 'selected' : ''}>${value[coloum]}</option>`;
                                    }
                                });
                                $('#' + append_element).html(option);
                            }
                        }else{
                            console.error(`There are no data in your database where model(${model})`);
                        }
                    }else{
                        console.error('Please fill up all argument carefully');
                    }
                }
            });
        }
</script>
@stack('page_scripts')
</body>
</html>
