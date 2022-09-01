@extends('layouts.staff.master')

@section('title','Lecturer')

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

@section('content-header')
    <ul class="breadcrumb breadcrumb-col-teal">
        <li class="breadcrumb-item"><a href="{{route('staff.lecturers.all')}}">All Lecturers</a></li>
        <li class="breadcrumb-item active"><a>{{$lecturer->name}}</a></li>
    </ul>
@endsection

@section('section-content-class','profile-page')

@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12 p-l-0 p-r-0">
                <section class="boxs-simple">
                    <div class="profile-header">
                        <div class="profile_info">
                            <div class="profile-image">
                                <div class="thumb-xl mx-auto">
                                    <img src="
                                    @if($lecturer->avatar=='') {{asset('img/staff/placeholder.jpg')}}
                                    @else {{asset('storage/'.$lecturer->avatar)}}
                                    @endif" alt="" style="object-fit:cover;height:100%;width:100%" id="avatar-thumb">
                                </div>
                            </div>
                            <h4 class="mb-0"><strong>
                                    @if($lecturer->title=='')
                                        @if($lecturer->gender=='0')Ms.@else Mr.@endif
                                    @else {{$lecturer->title}}
                                    @endif</strong> {{$lecturer->name}}</h4>
                            <span class="text-muted col-white">{{$lecturer->degree}}</span>
                            <div class="mt-10">
                                <a href="mailto:{{$lecturer->email}}" class="btn btn-raised g-bg-soundcloud2 btn-sm waves-effect">Send Mail</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-sub-header">
                        <div class="box-list">
                            <ul class="text-center">
                                <li> <a href="javascript:void(0);" id="change-avatar" data-toggle="modal" data-target="#AvatarModal"><i class="zmdi zmdi-image"></i>
                                        <p>Change Avatar</p>
                                    </a> </li>
                                <li> <a href="javascript:void(0);" id="change-password" data-toggle="modal" data-target="#PasswordModal"><i class="zmdi zmdi-lock-outline"></i>
                                        <p>Change Password</p>
                                    </a> </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div id="reload">
            <div class="row clearfix" id="basic-info">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>Description</h2>
                        </div>
                        <div class="body">
                            <p class="text-default">{{nl2br($lecturer->description)}}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Subjects & Classes</h2>
                        </div>
                        <div class="body">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="usersettings">
                                    <h2 class="card-inside-title">Account Settings</h2>
                                    <form method="post" id="basic-infos" action="{{route('staff.lecturers.update',['id'=>$lecturer->id])}}">
                                        @csrf
                                        <div class="row clearfix">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" value="{{explode(' ',$lecturer->name)[0]}}" name="last-name" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" value="{{implode(' ',array_slice(explode(' ',$lecturer->name),1))}}" name="first-name"  required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="datepicker form-control" value="{{\Illuminate\Support\Carbon::createFromFormat('Y-m-d',$lecturer->DoB)->format('d/m/Y')}}" name="DoB" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="gender" required>
                                                            <option value="">--Gender--</option>
                                                            <option value="1" @if($lecturer->gender=='1') selected @endif>Male</option>
                                                            <option value="0" @if($lecturer->gender=='0') selected @endif>Female</option>
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
                                                                <option value="{{$faculty->id}}" @if($lecturer->faculty_id===$faculty->id) selected @endif> {{$faculty->id.'. '.$faculty->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Title" name="title" value="{{$lecturer->title}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Degree" name="degree" value="{{$lecturer->degree}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control text-default" placeholder="Description..." name="description">@if($lecturer->description!=''){{$lecturer->description}}@endif</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-raised btn-success waves-effect">Save Changes</button>
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

@section('modal')
    <div class="modal fade" id="AvatarModal" tabindex="-1" role="dialog">
        <form action="{{route('staff.lecturers.update',['id'=>$lecturer->id])}}" method="post" id="avatar-form" enctype="multipart/form-data">
            @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-col-indigo">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Change Avatar</h4>
                </div>
                <div class="modal-body">
                    <div class="row py-4">
                        <div class="col-lg-8 mx-auto avatar-zone">
                            <!-- Uploaded image area-->
                            <div class="image-area mb-4 g-bg-blush2">
                                <img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block">
                            </div>
                            <!-- Upload image input-->
                            <div class="input-group mb-3 px-2 py-2 g-bg-blush2 shadow-sm ava-parent" style="border-radius: 32px;">
                                <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0" name="avatar" required>
                                <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose Avatar</label>
                                <div class="input-group-append">
                                    <label for="upload" class="btn btn-light m-0 px-4" style="border-radius: 32px;cursor: pointer">
                                        <i class="zmdi zmdi-cloud-upload mr-2 text-muted"></i>
                                        <small class="text-uppercase font-weight-bold text-muted">Choose Avatar</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
                    <button type="reset" class="btn btn-link waves-effect" data-dismiss="modal" id="close-ava">CLOSE</button>
                </div>
            </div>
        </div>
        </form>
    </div>

    <div class="modal fade" id="PasswordModal" tabindex="-1" role="dialog">
        <form action="{{route('staff.lecturers.update',['id'=>$lecturer->id])}}" method="post" id="password-form">
            @csrf
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content modal-col-indigo">
                <div class="modal-header">
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" class="form-control" placeholder="New Password" id="new-password" name="new-pass" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" class="form-control" placeholder="Confirm New Password" name="confirm" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
                    <button type="reset" class="btn btn-link waves-effect" data-dismiss="modal" id="close-pass">CLOSE</button>
                </div>
            </div>
        </div>
        </form>
    </div>
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

    {{--    Reset field     --}}
    <script>
        $(function (){
           $("#AvatarModal").on('hide.bs.modal', function (){
                $(this).find('form')[0].reset();
                $("#imageResult").attr('src','#');
                $("#upload-label").html('Choose Avatar');
           });
        });

        $(function (){
            $("#PasswordModal").on('hide.bs.modal', function (){
                $(this).find('form')[0].reset();
            });
        });
    </script>

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
            $('#basic-infos').validate({
                rules: {
                    'first-name': {
                        namecheck: true,
                    },
                    'last-name':{
                        namecheck: true,
                    },
                    'title':{
                        maxlength: 15,
                    },
                },
                messages:{
                    'title': "Title is too long!",
                },
                highlight: function (input) {
                    $(input).parents('.form-line').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.form-line').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-group').append(error);
                }
            });

            $('#avatar-form').validate({
                rules: {
                    'avatar':{
                        onlyimages: true,
                    },
                },
                highlight: function (input) {
                    $(input).parents('.ava-parent').siblings('.avazone').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.ava-parent').siblings('.avazone').removeClass('error');

                },
                errorPlacement: function (error, element) {
                    $(element).parents('.avatar-zone').append(error);
                }
            });

            $('#password-form').validate({
                rules: {
                    'new-pass':{
                        minlength: 8,
                        notEqual: '#old-password',
                    },
                    'confirm':{
                        equalTo : "#new-password",
                    },
                },
                messages:{
                    'confirm': "The password confirmation does not match!",
                    'password':{
                        minlength: "Passwords need 8 or more characters!",
                    }
                },
                highlight: function (input) {
                    $(input).parents('.form-line').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.form-line').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-group').append(error);
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

            //Password Change
            $.validator.addMethod("notEqual", function(value, element, param) {
                let oldpass = $(param).val();
                return value!==oldpass;
            }, "New password  need to be different from old one!");
            //==================================================================================================
        });
    </script>
    {{--    Ajax Form Submit    --}}
    <script>
        $(function (){
            $("#basic-infos").submit(function(e) {
                e.preventDefault();
                let actURL = $(this).attr("action");
                const formData = new FormData(this);
                formData.append('type','basic');
                if($(this).valid()){
                    callAJAX(actURL,formData);
                }
            });

            $("#password-form").submit(function(e) {
                e.preventDefault();
                let actURL = $(this).attr("action");
                const formData = new FormData(this);
                formData.append('type','password');
                if($(this).valid()){
                    callAJAX(actURL,formData,'pass');
                }
            });

            $("#avatar-form").submit(function(e) {
                e.preventDefault();
                let actURL = $(this).attr("action");
                const formData = new FormData(this);
                formData.append('type','avatar');
                if($(this).valid()) {
                    callAJAX(actURL, formData,'ava');
                }
            });

            function callAJAX(actURL,formData,type='basic'){
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            if(type!=='basic')  $("#close-"+type).click();
                            showNotification('g-bg-cgreen',response.message,'top','center','animated fadeInDown','animated fadeOutDown');
                            if(response.avatar) $("#avatar-thumb").attr('src',`{{asset('storage')}}/${response.avatar}`);
                            $('#reload').load(document.URL +  ' #basic-info');
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


