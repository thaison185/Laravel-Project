@extends('layouts.staff.master')

@section('title','Subjects')

@push('css')
    <style>
        .hiddenRow{
            padding:0!important;
        }
    </style>
@endpush

@section('content-header')
    <ul class="breadcrumb breadcrumb-col-teal">
        <li class="breadcrumb-item"><a href="{{route('staff.faculty-class.classes')}}">All Classes</a></li>
        <li class="breadcrumb-item active"><a>{{$class->name}}</a></li>
    </ul>
@endsection

@section('content')
    <div>
        <div class="row clearfix" id="subjects">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card panel panel-primary">
                    <div class="body table-responsive panel-body">
                        @for($each=1;$each<=$class->major->semester();$each++)
                            <div data-toggle="collapse" class="accordion-toggle text-center py-2 @if($each%2==0) bg-teal @else bg-cyan @endif"
                                 data-target="#semester{{$each}}" role="button" >
                                Semester #{{$each}}
                            </div>
                            <div class="accordian-body collapse" id="semester{{$each}}">
                                <table class="table table-bordered table-striped table-hover m-b-0" id="table-semester{{$each}}">
                                    <thead>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Lecturer</th>
                                    </thead>
                                    <tbody>
                                    @foreach($class->major->inSemester($each) as $majorSubject)
                                        <tr>
                                            <td>{{$majorSubject->subject->name}}</td>
                                            <td>
                                                <div class="row clearfix">
                                                    <div class="col-8">
                                                        <select class="form-control show-tick" name="lecturer_id">
                                                            {{$assignment=$class->assignment($majorSubject->id)}}
                                                            <option value="" @if(empty($assignment)) selected @endif>Choose Lecturer</option>
                                                            @foreach($lecturers as $lecturer)
                                                                <option value="{{$lecturer->id}}" @if(!empty($assignment)&&$assignment->lecturer->id === $lecturer->id) selected @endif>{{$lecturer->id}}. {{$lecturer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn waves-effect btn-raised btn-sm bg-light-blue float-right update-btn"
                                                                data-semester="{{$each}}"
                                                                data-href="{{route('staff.faculty-class.assignment',['id'=>$class->id])}}"
                                                                data-subject="{{$majorSubject->subject->id}}">Update</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('/staff-asset/plugins/jquery-validation/jquery.validate.js')}}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('staff-asset/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('/staff-asset/js/pages/ui/notifications.js')}}"></script>
    <script>
        $(function (){
            $(document).on('click','.update-btn',function (){
                const formData = new FormData();
                formData.append('_token','{{csrf_token()}}');
                formData.append('semester',$(this).data('semester'));
                formData.append('subject_id',$(this).data('subject'));
                let selected = $(this).parent().siblings('.col-8').find('select').find(':selected').val();
                console.log(selected);
                formData.append('lecturer_id',selected);
                let actURL = $(this).data('href');
                callAJAX(actURL,formData,$(this).data('semester'));
            })
            function callAJAX(actURL,formData,target=''){
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            showNotification('g-bg-cgreen',response.message,'top','center','animated fadeInDown','animated fadeOutDown');
                            if (target==='') $("#reload").load(document.URL+' #reload');
                            else $('#semester'+target).load(document.URL+ ' #table-semester'+target);
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
        })
    </script>
@endpush
