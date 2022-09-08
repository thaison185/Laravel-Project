@extends('layouts.staff.master')

@section('title','All Majors')

@push('css')
    <style>
        .hiddenRow{
            padding:0!important;
        }
    </style>
@endpush

@section('content-header')
    <div class="block-header">
        <h2>All Majors</h2>
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
                                data-action="{{route('staff.subject-major.storeMajor')}}">
                            Add Major
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="reload">
        <div class="row clearfix" id="majors">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card panel panel-primary">
                    <div class="body table-responsive panel-body">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                            <tr class="g-bg-cgreen">
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col" class="text-center">Name</th>
                                <th scope="col" class="text-center">Degree</th>
                                <th scope="col" class="text-center">Faculty</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="tbody">
                                @foreach($majors as $major)
                                    <tr>
                                        <td class="text-center">{{$major->id}}</td>
                                        <td class="text-center">{{$major->name}}</td>
                                        <td class="text-center">
                                            @switch($major->degree)
                                                @case('0')
                                                Bachelor
                                                @break
                                                @case('1')
                                                Engineer
                                                @break
                                                @case('2')
                                                Master
                                                @break
                                                @case('3')
                                                PhD Student
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="text-center">{{$major->faculty->name}}</td>
                                        <td class="text-center">{{$major->description}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-circle waves-effect waves-circle waves-float accordion-toggle"
                                                    data-placement="bottom" title="All Subjects"
                                                    data-toggle="collapse" data-target="#target{{$major->id}}">
                                                <i class="zmdi zmdi-format-subject text-warning"></i>
                                            </button>
                                            <button type="button"
                                                    data-action="{{route('staff.subject-major.updateMajor',['id'=>$major->id])}}"
                                                    data-name="{{$major->name}}"
                                                    data-description="{{$major->description}}"
                                                    data-degree="{{$major->degree}}"
                                                    data-faculty="{{$major->faculty_id}}"
                                                    data-toggle="modal" data-target="#Modal"
                                                    data-type="update"
                                                    data-id="{{$major->id}}"
                                                    class="btn btn-circle waves-effect waves-circle waves-float"><i class="zmdi zmdi-edit text-info"></i>
                                            </button>
                                            @if(auth()->user()->role=='1')
                                                <button data-href="{{route('staff.subject-major.deleteMajor',['id'=>$major->id])}}" class="btn btn-circle waves-effect waves-float waves-circle delete-button"><i class="zmdi zmdi-delete text-danger"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="hiddenRow">
                                            <div class="accordian-body collapse" id="target{{$major->id}}">
                                                @for($each=1;$each<=$major->semester();$each++)
                                                    <div data-toggle="collapse" class="accordion-toggle text-center py-2 @if($each%2==0) bg-teal @else bg-cyan @endif" data-target="#{{$major->id}}semester{{$each}}">
                                                        Semester #{{$each}}
                                                    </div>
                                                    <div class="accordian-body collapse" id="{{$major->id}}semester{{$each}}">
                                                        <table class="table table-bordered table-striped m-b-0" id="table-{{$major->id}}-semester{{$each}}">
                                                            <thead>
                                                                <th>Subject</th>
                                                                <th>Lecture Hour</th>
                                                                @if(auth()->user()->role=='1')<th>Action</th>@endif
                                                            </thead>
                                                            <tbody>
                                                                @foreach($major->inSemester($each) as $subject)
                                                                    <tr>
                                                                        <td>{{$subject['subject']->name}}</td>
                                                                        <td>{{$subject['hour']}}</td>
                                                                        @if(auth()->user()->role=='1')
                                                                            <td><button
                                                                                    data-href="{{route('staff.subject-major.deleteSubjectMajor',['major'=>$major->id,'subject'=>$subject['subject']->id,'semester'=>$each])}}"
                                                                                    data-major="{{$major->id}}"
                                                                                    data-semester="{{$each}}"
                                                                                    class="btn btn-circle waves-effect waves-float waves-circle remove-button">
                                                                                    <i class="material-icons text-danger">remove_circle_outline</i>
                                                                                </button></td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                                @if(auth()->user()->role=='1')
                                                                    <tr>
                                                                        <td role="button" colspan="12" class="hiddenRow text-center"
                                                                            data-toggle="modal" data-target="#AddSubjectModal"
                                                                            data-major="{{$major->id}}"
                                                                            data-semester="{{$each}}">
                                                                            <i class="material-icons m-t-5">add</i>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endfor
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <ul class="p-b-10 pagination justify-content-center" >
                            {{$majors->links()}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
        <form method="post" id="update-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-col-blue-grey">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel"></h4>
                    </div>
                    <div class="modal-body append-here">
                        <div class="row clearfix">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4" id="select-degree">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="degree" required>
                                            <option value="">--Degree--</option>
                                            <option value="0"> 0.Bachelor</option>
                                            <option value="1"> 1.Engineer</option>
                                            <option value="2"> 2.Master</option>
                                            <option value="3"> 3.PhD Student</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-8" id="select-faculty">
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="4" class="form-control no-resize" placeholder="Description..." name="description"></textarea>
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

    <div class="modal fade" id="AddSubjectModal" tabindex="-1" role="dialog">
        <form method="post" id="add-form" action="{{route('staff.subject-major.addSubjectMajor')}}">
            @csrf
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content modal-col-blue-grey">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Subject</h4>
                    </div>
                    <div class="modal-body append-here">
                        <div class="row clearfix">
                            <div class="col-md-6 col-sm-6" id="select-subject">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="subject_id" required>
                                            <option value="">--Subject--</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{$subject->id}}"> {{$subject->id.'. '.$subject->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="lecture_hour" placeholder="Lecture Hour" min="70" max="300" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="reset" class="btn btn-link waves-effect" data-dismiss="modal" id="close-add">CLOSE</button>
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
            });
        });

        $(function (){
            $("#AddSubjectModal").on('hide.bs.modal', function (){
                $(this).find('form')[0].reset();
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
                modal.find('input[name="name"]').val(button.data('name'));
                modal.find('textarea[name="description"]').val(button.data('description'));
                let degree = button.data('degree');
                $('#select-degree').find('option:contains("'+degree+'")').prop("selected",true);
                let faculty = button.data('faculty');
                $('#select-faculty').find('option:contains("'+faculty+'")').prop("selected",true);
                $('#defaultModalLabel').text('Update Major #'+button.data('id'))
            }else{
                modal.find('.append-here').append($('<input type="hidden" name="type" value="add" class="type">'));
                $('#defaultModalLabel').text('Add Major')
            }
        })

    </script>
    {{--    Input fields validate      --}}
    <script>
        $(function () {
            $('#update-form').validate({
                rules: {
                    'first-name': {
                        maxlength: 50,
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
                },
            });
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
            let button;
            $('#AddSubjectModal').on('show.bs.modal', function (event) {
                button = $(event.relatedTarget);
            });
            $('#add-form').submit(function (e){
                e.preventDefault();
                let actURL = $(this).attr("action");
                const formData = new FormData(this);
                formData.append("major_id",button.data('major'));
                formData.append("semester",button.data('semester'));
                callAJAX(actURL, formData,button.data('semester'));
            });

            function callAJAX(actURL,formData,target=''){
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            $("#close-ava").click();
                            $("#close-add").click();
                            showNotification('g-bg-cgreen',response.message,'top','center','animated fadeInDown','animated fadeOutDown');
                            if (target==='') $("#reload").load(document.URL+' #reload');
                            else $('#'+formData.get('major_id')+'semester'+target).load(document.URL+ ' #table-'+formData.get('major_id')+'-semester'+target);
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

            $(document).on('click','.remove-button',function (){
                if (confirm("You really want to delete this subject?") === true) {
                    const formData = new FormData();
                    formData.append('_token','{{csrf_token()}}');
                    formData.append('major_id',$(this).data('major'));
                    let actURL = $(this).data('href');
                    callAJAX(actURL,formData,$(this).data('semester'));
                }
            });
        });
    </script>
@endpush
