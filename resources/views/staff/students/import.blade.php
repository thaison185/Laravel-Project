@extends('layouts.staff.master')

@section('title','Import Students by CSV')

@section('content-header')
    <div class="block-header">
        <h2>Import Students by CSV</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@push('css')
    <link href="{{asset('staff-asset/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
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

@section('content')
    <form  method="post" enctype="multipart/form-data" id="needs-validation" action="{{route('staff.students.import')}}">
        @csrf
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <div class="row py-4">
                            <div class="col-lg-10 mx-auto avatar-zone">
                                <!-- Upload image input-->
                                <div class="input-group mb-3 px-2 py-2 g-bg-cgreen shadow-sm ava-parent" style="border-radius: 32px;">
                                    <input id="upload" type="file" class="form-control border-0" name="file">
                                    <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose Data File</label>
                                    <div class="input-group-append">
                                        <label for="upload" class="btn btn-light m-0 px-4" style="border-radius: 32px;cursor: pointer;">
                                            <i class="zmdi zmdi-cloud-upload mr-2 text-muted"></i>
                                            <small class="text-uppercase font-weight-bold text-muted">Choose Data File</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix d-none" id="preview">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <h2>Data from file preview <small class="number-of-records"></small></h2>
                        </div>
                        <div class="col-6 control-buttons">
                            <button type="submit" class="btn btn-raised g-bg-blush2 m-t-25 waves-effect">Submit</button>
                            <button type="reset" class="btn btn-raised bg-blue-grey m-t-25 waves-effect clear">Cancel</button>
                        </div>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-hover" id="excel">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Class ID</th>
                                <th scope="col">Gender</th>
                                <th scope="col">DOB</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Description</th>
                            </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                        </table>
                        <div class="number-of-records"></div>
                        <div class="col-sm-12 text-center control-buttons">
                            <button type="submit" class="btn btn-raised g-bg-blush2 waves-effect">Submit</button>
                            <button type="reset" class="btn btn-raised bg-blue-grey waves-effect clear">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>
@endsection

@push('js')
    <script src="{{asset('staff-asset/bundles/datatablescripts.bundle.js')}}"></script>
    <script src="{{asset('staff-asset/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('staff-asset/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('staff-asset/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('staff-asset/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
    <script src="{{asset('staff-asset/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
    <script src="{{asset('staff-asset/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>

    <script src="{{asset('/staff-asset/plugins/jquery-validation/jquery.validate.js')}}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('/staff-asset/plugins/jquery-steps/jquery.steps.js')}}"></script> <!-- JQuery Steps Plugin Js -->

    <!-- Bootstrap Notifications and Custom notification -->
    <script src="{{asset('staff-asset/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('/staff-asset/js/pages/ui/notifications.js')}}"></script>

    {{--    CSV upload file name preview     --}}
    <script>
        $(function(){
            function renderTable(target,data,fails){
                let countSuccess = 0;
                data.forEach(function (value,index){
                    if(!renderRow(value,fails[index],index,target)) countSuccess++;
                });
                $(".number-of-records").html(`Number of records: ${data.length}<br>Number of success records: ${countSuccess}`);
            }

            function renderRow(data,fail,index,target){
                let hasFails=false;
                let row = $("<tr />");
                $(target).children(".tbody").append(row);
                if (fail.length!==0){
                    row.addClass("bg-amber");
                    hasFails=true;
                }else row.addClass("g-bg-cgreen");
                row.append($("<th scope='row'>" + index + "</th>"));
                const order=['name','email','password','class_id','gender','dob','phone','description'];
                order.forEach(function (value){
                   if(hasFails){
                       if (fail.hasOwnProperty(value)){
                           row.append($("<td class='bg-red'>"
                               + data[value]
                               + "<br>" +
                               "<small class='font-weight-bold font-italic'>" +
                               "<i class='material-icons' style='font-size:11px!important;'>error_outline</i>"
                               +fail[value]+"</small></td>"));
                       }else row.append($("<td>" + data[value] + "</td>"));
                   }
                   else row.append($("<td>" + data[value] + "</td>"));
                });
                return hasFails;
            }
            /*  ==========================================
            GET DATA TO FETCH TO DATA TABLES
        * ========================================== */
            function AJAXGetData(){
               let formData = new FormData($("#needs-validation")[0]);
               formData.append("type","preview");
               let actURL = $("needs-validation").attr("action");
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            showNotification('g-bg-cgreen','File loaded successfully!','top','center','animated fadeInDown','animated fadeOutDown');
                            let data = response.data;
                            let fails = response.fails;
                            $("#preview").removeClass("d-none");
                            renderTable("#excel",data,fails);
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
                            error = response.message;
                        }
                        showNotification('g-bg-soundcloud',error,'top','center','animated zoomInDown','animated zoomOutUp');

                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: "multipart/form-data",
                    async: false,
                });
           };
            /*  ==========================================
             SHOW UPLOADED IMAGE NAME
         * ========================================== */
            var input = document.getElementById( 'upload' );
            var infoArea = document.getElementById( 'upload-label' );

            input.addEventListener( 'change', showFileName );
            function showFileName( event ) {
                var input = event.srcElement;
                infoArea.textContent = input.files[0].name;
                AJAXGetData();
            }
        });
    </script>

    {{--    CLEAR ALL WHEN CANCEL CLICKED   --}}
    <script>
        $(function (){
            $(".clear").click(function (){
                $("#excel").children(".tbody").html("");
                $(".number-of-records").html("");
                $("#preview").addClass("d-none");
                $('#upload-label').html("Choose Data File");
            })
        });
    </script>

    {{--    FORM SUBMIR HANDLE   --}}
    <script>
        $(function (){
            $("#needs-validation").submit(function (e){
                e.preventDefault();
                let actURL = $(this).attr("action");
                let formData = new FormData(this);
                formData.append("type","import");
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            showNotification('g-bg-cgreen',"Import Successfully!",'top','center','animated fadeInDown','animated fadeOutDown');
                            $("small.number-of-records").parent().html("Import Results & Reports<small class='number-of-records'></small>");
                            $("div.number-of-records").remove();
                            let fails = response.fails;
                            let errors = response.errors;
                            let count = response.count - errors.length;
                            $(".number-of-records").html("Success Imported record: "+count);
                            $("#excel").remove();
                            $(".control-buttons").remove();
                            $(".table-responsive").append($("<div class='row clearfix'><div class='col-12'><div class='panel-group full-body' id='panel' role='tablist' aria-multiselectable='true'></div></div></div>"));
                            $("#panel").html(
                                `<div class="panel panel-col-red">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="panel" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Errors</a> </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body"><ul id="errors-data"></ul></div>
                                    </div>
                                </div>
                                <div class="panel panel-col-amber">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="panel" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Fails</a> </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body"><ul id="fails-data"></ul></div>
                                    </div>
                                </div>`
                            );
                            errors.forEach(function (each){
                               $("#errors-data").append($("<li>"+each.errorInfo[2]+"</li>"));
                            });
                            fails.forEach(function (each){
                                $("#fails-data").append($("<li>Row "+(each.row-2)+", attribute "+each.attribute+": "+each.errors+"</li>"));
                            });
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
                            error = response.message;
                        }
                        showNotification('g-bg-soundcloud',error,'top','center','animated zoomInDown','animated zoomOutUp');

                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: "multipart/form-data",
                    async: false,
                });
            });
        });
    </script>
@endpush
