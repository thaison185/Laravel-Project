@extends('layouts.staff.master')

@section('title','All Staff')

@push('css')
    <style>
        #upload {
            opacity: 0;
        }

        #upload-label {
            position: absolute;
            top: 50%;
            left: .5rem;
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
            font-size: 0.6rem;
            z-index: 1;
        }

        .image-area img {
            z-index: 2;
            position: relative;
        }
    </style>
@endpush

@section('content-header')
    <div class="block-header">
        <h2>All Staff</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@section('content')
    @if(auth()->user()->role=='1')
        <div class="row m-b-10">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="btn-group float-right m-r-20">
                        <button type="button"
                                class="btn btn-raised bg-blush waves-effect"
                                data-toggle="modal" data-target="#Modal" data-type="add"
                                data-action="{{route('staff.staff.store')}}">
                            Add staff
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="reload">
        <div class="row clearfix" id="staff-all">
            @foreach($staff as $each)
                <x-staffcard>
                    <x-slot name="avatar">
                        @if($each->avatar=='') {{asset('/img/staff/placeholder.jpg')}}
                        @else {{asset('storage/'.$each->avatar)}}
                        @endif
                    </x-slot>
                    <x-slot name="id">{{$each->id}}</x-slot>
                    <x-slot name="name">
                        {{$each->name}}
                    </x-slot>
                    <x-slot name="email">
                        {{$each->email}}
                    </x-slot>
                    <x-slot name="role">
                        {{$each->role}}
                    </x-slot>
                    <x-slot name="gender">
                        {{$each->gender}}
                    </x-slot>
                </x-staffcard>
            @endforeach
        </div>
    </div>
    <ul class="p-b-10 pagination justify-content-center" >
        {{$staff->links()}}
    </ul>
@endsection

@section('modal')
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
        <form method="post" id="update-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-col-blue-grey">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Update Staff</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control text-white" name="last-name" placeholder="Last Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control text-white" name="first-name" placeholder="First Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick text-white" name="gender" required>
                                            <option value="">--Gender--</option>
                                            <option value="1">Male</option>
                                            <option value="0">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick text-white" name="role" required>
                                            <option value="">--Role--</option>
                                            <option value="1">Administrator</option>
                                            <option value="0">Staff</option>
                                        </select>
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
                        </div>
                        <div class="row clearfix append-here">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class="form-control text-white" placeholder="New Password" id="new-password" name="new-pass">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class="form-control text-white" placeholder="Confirm New Password" id="confirm" name="confirm">
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
@endsection

@push('js')
    <script src="{{asset('/staff-asset/plugins/jquery-validation/jquery.validate.js')}}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('staff-asset/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('/staff-asset/js/pages/ui/notifications.js')}}"></script>

    {{--    Reset field     --}}
    <script>
        $(function (){
            $("#Modal").on('hide.bs.modal', function (){
                $(this).find('form')[0].reset();
                $(this).find('input[name="type"]').remove();
                $("#imageResult").attr('src','#');
                $("#upload-label").html('Choose Avatar');
                $(this).find('.email-here').remove();
                $(this).find('.type').remove();
                $('#new-password').prop('required',false);
                $('#confirm').prop('required',false);
            });
        });
    </script>
    {{--    Modal   --}}
    <script>
        $('#Modal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let modal = $(this);
            modal.find('form').attr('action',button.data('action'));
            if(button.data('type')=='update'){
                modal.find('.append-here').append($('<input type="hidden" name="type" value="update" class="type">'));
                modal.find('input[name="last-name"]').val(button.data('lastname'));
                modal.find('input[name="first-name"]').val(button.data('firstname'));
                let gender = button.data('gender');
                if(gender=='0') modal.find("option:contains('Female')").prop("selected",true);
                else modal.find("option:contains('Male')").prop("selected",true);
                let role = button.data('role');
                if(role=='0') modal.find("option:contains('Staff')").prop("selected",true);
                else modal.find("option:contains('Administrator')").prop("selected",true);
            }else{
                modal.find('.append-here').append($('<input type="hidden" name="type" value="add" class="type">'));
                $('#new-password').prop('required',true);
                $('#confirm').prop('required',true);
                modal.find('.append-here').append($('<div class="col-sm-12 email-here"><div class="form-group"><div class="form-line"><input type="email" class="form-control text-white" placeholder="Email" name="email" required></div></div></div>'));
            }
        })
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
            $('#update-form').validate({
                rules: {
                    'first-name': {
                        namecheck: true,
                    },
                    'last-name':{
                        namecheck: true,
                    },
                    'avatar':{
                        onlyimages: true,
                    },
                    'new-pass':{
                        minlength: 8,
                    },
                    'confirm':{
                        passwordConfirm : "#new-password",
                    },
                },
                messages:{
                    'password':{
                        minlength: "Passwords need 8 or more characters!",
                    }
                },
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

            $.validator.addMethod("passwordConfirm", function (value, element,param) {
                    let password = $(param).val();
                    if (password!='') return value==password;
                    return true;
                },
                'The password confirmation does not match!'
            );
        });
    </script>
    {{--    Ajax Form Submit    --}}
    <script>
        $(function () {
            $("#update-form").submit(function (e) {
                e.preventDefault();
                let actURL = $(this).attr("action");
                const formData = new FormData(this);
                if ($(this).valid()) {
                    callAJAX(actURL, formData);
                }
            });
            function callAJAX(actURL,formData=''){
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            $("#close-ava").click();
                            showNotification('g-bg-cgreen',response.message,'top','center','animated fadeInDown','animated fadeOutDown');
                            $("#reload").load(document.URL+' #staff-all');
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
            $(document).on('click','.delete-button',function (){
                if (confirm("You really want to delete this major?") === true) {
                    const formData = new FormData();
                    formData.append('_token','{{csrf_token()}}');
                    let actURL = $(this).data('href');
                    callAJAX(actURL,formData);
                }
            });
        });
    </script>
@endpush
