@extends('layouts.staff.master')

@section('content-header')
    <div class="block-header">
        <h2>Add Lecturer</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@push('css')
    <link href="{{asset('/staff-asset/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/staff-asset/plugins/waitme/waitMe.css')}}" rel="stylesheet">
    <style>
        #upload {
            opacity: 0;
        }

        #upload-label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
        }

        .image-area {
            border: 2px dashed rgba(255, 255, 255, 0.7);
            padding: 1rem;
            position: relative;
        }

        .image-area::before {
            content: 'Uploaded avatar result';
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8rem;
            z-index: 1;
        }

        .image-area img {
            z-index: 2;
            position: relative;
        }
    </style>
@endpush

@section('title','Add Lecturer')

@section('content')
    <form  method="post" enctype="multipart/form-data" id="needs-validation" action="{{route('staff.lecturers.store')}}">
        @csrf
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Basic Information <small>Some information of new lecturer</small> </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="First Name" name="first-name"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Last Name" name="last-name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="datepicker form-control" placeholder="Date of Birth" name="DoB" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="gender" required>
                                            <option value="">--Gender--</option>
                                            <option value="1">Male</option>
                                            <option value="0">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="faculty_id" required>
                                            <option value="">--Faculty--</option>
                                            @foreach($faculties as $faculty)
                                                <option value="{{$faculty->id}}"> {{$faculty->id.'. '.$faculty->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Title" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Degree" name="degree">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-4">
                            <div class="col-lg-8 mx-auto avatar-zone">
                                <!-- Uploaded image area-->
                                <div class="image-area mb-4 g-bg-blush2">
                                    <img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block">
                                </div>
                                <!-- Upload image input-->
                                <div class="input-group mb-3 px-2 py-2 g-bg-blush2 shadow-sm ava-parent" style="border-radius: 32px;">
                                    <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0" name="avatar">
                                    <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose Avatar</label>
                                    <div class="input-group-append">
                                        <label for="upload" class="btn btn-light m-0 px-4" style="border-radius: 32px;cursor: pointer">
                                            <i class="zmdi zmdi-cloud-upload mr-2 text-muted"></i>
                                            <small class="text-uppercase font-weight-bold text-muted">Choose Avatar</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="4" class="form-control no-resize" placeholder="Description..." name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Lecturer's Account Information <small>Email and Password for new Lecturer</small></h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="email" class="form-control g-bg-" placeholder="Email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class="form-control" placeholder="Confirm Password" name="confirm" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-raised g-bg-blush2 waves-effect">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{asset('/staff-asset/plugins/autosize/autosize.js')}}"></script> <!-- Autosize Plugin Js -->
    <script src="{{asset('/staff-asset/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js -->
    <script src="{{asset('/staff-asset/plugins/jquery-validation/jquery.validate.js')}}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('/staff-asset/plugins/jquery-steps/jquery.steps.js')}}"></script> <!-- JQuery Steps Plugin Js -->
    <script src="{{asset('/staff-asset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- Bootstrap Notifications and Custom notification -->
    <script src="{{asset('staff-asset/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('/staff-asset/js/pages/ui/notifications.js')}}"></script>

    {{--    Datetime Picker     --}}
    <script>
        let year = new Date().getFullYear()-22;
        let maxdate = '31/12/'+year;
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            time: false,
            maxDate: maxdate,
        });
    </script>
    {{--    Avatar upload image preview     --}}
    <script>
        /*  ==========================================
            SHOW UPLOADED IMAGE
        * ========================================== */
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imageResult')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $('#upload').on('change', function () {
                readURL(input);
            });
        });

        /*  ==========================================
            SHOW UPLOADED IMAGE NAME
        * ========================================== */
        var input = document.getElementById( 'upload' );
        var infoArea = document.getElementById( 'upload-label' );

        input.addEventListener( 'change', showFileName );
        function showFileName( event ) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = 'Image name: ' + fileName;
        }
    </script>
    {{--    Input fields validate      --}}
    <script>
        $(function () {
            $('#needs-validation').validate({
                rules: {
                    'first-name': {
                        namecheck: true,
                    },
                    'last-name':{
                        namecheck: true,
                    },
                    'email':{
                        emailcheck: true,
                    },
                    'password':{
                        minlength: 8,
                    },
                    'confirm':{
                        equalTo : "#password",
                    },
                    'title':{
                        maxlength: 15,
                    },
                    'avatar':{
                        onlyimages: true,
                    },
                },
                messages:{
                    'confirm': "The password confirmation does not match!",
                    'title': "Title is too long!",
                    'password':{
                        minlength: "Passwords need 8 or more characters!",
                    }
                }
                ,
                highlight: function (input) {
                    $(input).parents('.form-line').addClass('error');
                    $(input).parents('.ava-parent').siblings('.avazone').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.form-line').removeClass('error');
                    $(input).parents('.ava-parent').siblings('.avazone').removeClass('error');

                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-group').append(error);
                    $(element).parents('.avatar-zone').append(error);
                }
            });

            //Custom Validations ===============================================================================
            //Name
            $.validator.addMethod('namecheck', function (value, element) {
                    let reg='[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]';
                    let regCap = '[A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴÝỶỸ]';
                    return value.match(regCap+reg+'{1,}');
                },
                'Please enter a valid name!'
            );

            //Email
            $.validator.addMethod('emailcheck', function (value, element) {
                    return value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/);
                },
                'Please enter a valid email!'
            );

            //Image
            $.validator.addMethod("onlyimages", function (value, element) {
                    if (this.optional(element) || !element.files || !element.files[0]) {
                        return true;
                    } else {
                        var fileType = element.files[0].type;
                        var isImage = /^(image)\//.test(fileType);
                        return isImage;
                    }
                },
                'Sorry, we can only accept image files.'
            );
            //==================================================================================================
        });
    </script>
    {{--    Ajax Form Submit    --}}
    <script>
        $("#needs-validation").submit(function(e) {
            e.preventDefault();
            let actURL = "{{route('staff.lecturers.store')}}";
            const formData = new FormData(this);
            if($('#needs-validation').valid()){
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            showNotification('g-bg-cgreen',response.message,'top','center','animated fadeInDown','animated fadeOutDown');
                        }else{
                            showNotification('g-bg-soundcloud',response.message,'top','center','animated zoomInDown','animated zoomOutUp');
                        }
                    },
                    error: function (response){
                        let error ='';
                        if(response.responseJSON.errors){
                            let errors = Object.values(response.responseJSON.errors);
                            if(Array.isArray(errors)){
                                errors.forEach(function (each){
                                    each.forEach(function(message){
                                        error+=`${message}<br>`;
                                    });
                                });
                            }
                            else{
                                error+=`${errors}`;
                            }
                        }
                        else {
                            error = response.responseJSON.message;
                        }
                        showNotification('g-bg-soundcloud',error,'top','center','animated zoomInDown','animated zoomOutUp');

                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: "multipart/form-data",
                    async: false,
                });
            }
        });
    </script>
@endpush
