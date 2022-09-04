@extends('layouts.staff.master')

@section('title','All Students')

@section('content-header')
    <div class="block-header">
        <h2>All Students</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@section('content')
    <div class="row m-b-10">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="body">
                    <form action="{{route('staff.students.all')}}" method="post">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="search">
                                        <label class="form-label">Search</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="faculty" id="faculty">
                                            <option value="" @if($filter['faculty']=='') selected @endif>All Faculties</option>
                                            @foreach($faculties as $faculty)
                                                <option value="{{$faculty->id}}" @if($filter['faculty']==$faculty->id) selected @endif>
                                                    {{$faculty->id.'. '.$faculty->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="major" id="major">
                                            <option value="" @if($filter['major']=='') selected @endif>All Major</option>
                                            @foreach($majors as $major)
                                                <option value="{{$major->id}}" @if($filter['major']==$major->id) selected @endif>
                                                    {{$major->id.'. '.$major->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="class" id="class">
                                            <option value="" @if($filter['class']=='') selected @endif>All Class</option>
                                            @foreach($classes as $class)
                                                <option value="{{$class->id}}" @if($filter['class']==$class->id) selected @endif>
                                                    {{$class->id.'. '.$class->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <button type="submit" class="btn btn-raised btn-info m-t-25 waves-effect">Filter</button>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5">
                                <div class="btn-group m-t-25">
                                    <button type="button" class="btn btn-raised bg-blush dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Add Students
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('staff.students.create')}}">Manually</a></li>
                                        <li><a href="{{route('staff.students.import-index')}}">Import CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="reload">
        <div class="row clearfix" id="student-all">
            @foreach($students as $student)
                <x-studentcard>
                    <x-slot name="avatar">
                        @if($student->avatar=='') {{asset('/img/staff/placeholder.jpg')}}
                        @else {{asset('storage/'.$student->avatar)}}
                        @endif
                    </x-slot>
                    <x-slot name="id">{{$student->id}}</x-slot>
                    <x-slot name="major">
                        {{$student->major->name}}
                    </x-slot>
                    <x-slot name="class">
                        {{$student->classs->name}}
                    </x-slot>
                    <x-slot name="name">
                        {{$student->name}}
                    </x-slot>
                    <x-slot name="email">
                        {{$student->email}}
                    </x-slot>
                    <x-slot name="phone">
                        {{$student->phone}}
                    </x-slot>
                </x-studentcard>
            @endforeach
        </div>
    </div>
    <ul class="p-b-10 pagination justify-content-center" >
        {{$students->links()}}
    </ul>
@endsection

@push('js')
    <script src="{{asset('/staff-asset/plugins/jquery-validation/jquery.validate.js')}}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('staff-asset/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('/staff-asset/js/pages/ui/notifications.js')}}"></script>
    <script>
        $(function (){
            let majors = @json($majors);
            let classes = @json($classes);
            function getSelectedFaculty(){
                return $('#faculty').children('option:selected').val();
            }

            function getSelectedMajor(){
                return $('#major').children('option:selected').val();
            }

            function fetchMajor(faculty){
                $('#major').find('option:not(:first)').remove();
                $('#class').find('option:not(:first)').remove();
                majors.forEach(function (each){
                    if(each['faculty_id']==faculty)
                    {
                        $('#major').append($("<option value='"+each.id+"'>"+each.id+". "+each.name+"</option>"));
                        fetchClass(each.id);
                    }
                });
            }

            function fetchClass(major){
                classes.forEach(function (each){
                    if(each['major_id']==major) $('#class').append($("<option value='"+each.id+"'>"+each.id+". "+each.name+"</option>"));
                });
            }

            $('#faculty').on('change',function (){
                let faculty=getSelectedFaculty();
                fetchMajor(faculty);
            });

            $('#major').on('change',function(){
               let major = getSelectedMajor();
               $('#class').find('option:not(:first)').remove();
               fetchClass(major);
            });
        })
    </script>
    <script>
        $(function(){
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
                            $("#reload").load(document.URL+' #student-all');
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
        })
    </script>
@endpush
