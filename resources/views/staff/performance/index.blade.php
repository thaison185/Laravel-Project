@extends('layouts.staff.master')

@section('title','Performance')

@section('content-header')
    @switch($type)
        @case('all')
        <div class="block-header">
            <h2>Performances</h2>
            <small class="text-muted">X University Application</small>
        </div>
        @break
        @case('faculty')
        <div class="block-header">
            <ul class="breadcrumb breadcrumb-col-teal">
                <li class="breadcrumb-item"><a href="{{route('staff.performance.all',['target'=>'all'])}}">All</a></li>
                <li class="breadcrumb-item active"><a>{{$faculty->name}}</a></li>
            </ul>
        </div>
        @break
        @case('major')
        <div class="block-header">
            <ul class="breadcrumb breadcrumb-col-teal">
                <li class="breadcrumb-item"><a href="{{route('staff.performance.all',['target'=>'all'])}}">All</a></li>
                <li class="breadcrumb-item"><a href="{{route('staff.performance.all',['target'=>'faculty','id'=>$major->faculty->id])}}">{{$major->faculty->name}}</a></li>
                <li class="breadcrumb-item active"><a>{{$major->name}}</a></li>
            </ul>
        </div>
        @break
        @case('class')
        <div class="block-header">
            <ul class="breadcrumb breadcrumb-col-teal">
                <li class="breadcrumb-item"><a href="{{route('staff.performance.all',['target'=>'all'])}}">All</a></li>
                <li class="breadcrumb-item"><a href="{{route('staff.performance.all',['target'=>'faculty','id'=>$class->major->faculty->id])}}">{{$class->major->faculty->name}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('staff.performance.all',['target'=>'major','id'=>$class->major->id])}}">{{$class->major->name}}</a></li>
                <li class="breadcrumb-item active"><a>{{$class->name}}</a></li>
            </ul>
        </div>
        @break
    @endswitch
@endsection

@section('content')
    <div class="row m-b-10">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="btn-group float-right m-r-20">
                    <a class="btn btn-raised g-bg-blush2 waves-effect analyze-btn" data-href="@switch($type)
                        @case('all') {{route('staff.performance.analyze',['target'=>'all'])}} @break
                        @case('faculty') {{route('staff.performance.analyze',['target'=>'faculty','id'=>$faculty->id])}} @break
                        @case('major') {{route('staff.performance.analyze',['target'=>'major','id'=>$major->id])}} @break
                        @case('class') {{route('staff.performance.analyze',['target'=>'class','id'=>$class->id])}} @break
                    @endswitch">
                        Analyze
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="container">
        <div id="replaceable" class="row clearfix">
            @switch($type)
                @case('all')
                    @foreach($faculties as $faculty)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="{{route('staff.performance.all',['target'=>'faculty','id'=>$faculty->id])}}">
                                <div class="card" role="button">
                                    <div class="body" style="height: 150px">
                                        <h4 class="m-b-0 col-teal">{{$faculty->name}}</h4>
                                        <small><i class="text-muted">{{$faculty->description}}</i></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                {{$faculties->links()}}
                @break
                @case('faculty')
                @foreach($majors as $major)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <a href="{{route('staff.performance.all',['target'=>'major','id'=>$major->id])}}">
                            <div class="card" role="button">
                                <div class="body" style="height: 100px">
                                    <h4 class="m-b-0 col-indigo">{{$major->name}}</h4>
                                    <small><i class="text-muted">{{$major->description}}</i></small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {{$majors->links()}}
                @break
                @case('major')
                @foreach($classes as $class)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <a href="{{route('staff.performance.all',['target'=>'class','id'=>$class->id])}}">
                            <div class="card" role="button">
                                <div class="body">
                                    <h4 class="m-b-0 col-pink">{{$class->name}}</h4>
                                    <small><i class="text-muted">{{$class->description}}</i></small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {{$classes->links()}}
                @break
                @case('class')
                @foreach($students as $student)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="body">
                                    <div class="member-card verified">
                                        <div class="thumb-xl member-thumb">
                                            <img src="@if($student->avatar=='') {{asset('/img/staff/placeholder.jpg')}}
                                            @else {{asset('storage/'.$student->avatar)}}
                                            @endif" class="img-thumbnail rounded-circle" alt="profile-image" style="object-fit: cover; height:100%">
                                        </div>
                                        <div class="m-t-20">
                                            <h4 class="m-b-0">{{$student->name}}</h4>
                                            <a href="{{route('staff.performance.show',['student'=>$student->id])}}" class="btn btn-raised btn-sm bg-teal waves-effect">Performance</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                @endforeach
                {{$students->links()}}
                @break
            @endswitch
        </div>
    </div>
@endsection



@push('js')
    <script src="{{asset('/staff-asset/plugins/jquery-validation/jquery.validate.js')}}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('staff-asset/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('/staff-asset/js/pages/ui/notifications.js')}}"></script>

    <script>
        $(function (){
            $(document).on('click','.analyze-btn',function (){
                let actURL = $(this).data('href')
                const formData = new FormData()
                formData.append('_token','{{csrf_token()}}')
                callAJAX(actURL,formData)
            })
            function callAJAX(actURL,formData){
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    success: function(response) {
                        showReport(response,'{{$type}}')
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
                    async: false,
                });
            }

            function randomColor(){
                let r = Math.floor(Math.random() * 255);
                let g = Math.floor(Math.random() * 255);
                let b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
            }
            function showReport(response,type){
                $('#container').empty();
                $('#container').append($('<div id="total" class="card"><div class="body text-center col-teal"><h4>Total Student: '+response.total+'<h4></div></div>'));
                $('#container').append($('<div id="report" class="row clearfix"></div>'))
                $('#container').append($('<div class="card"><div class="body text-center col-teal"><button id="list" class="btn btn-raised g-bg-soundcloud waves-effect">Back to List view</button></div></div>'))
                $('#list').on('click',function (){
                    $('#container').load(document.URL + ' #replaceable')
                })
                let labels = [];
                let colors = [];
                let config1 = null;
                let config2 = null;

                @if($type == 'all' || $type == 'faculty')
                    $('#report').append($('<div class="col-md-6 col-sm-12"><div class="card"><div class="header text-center">NUMBER STUDENTS</div><div class="body"><canvas id="numStudents" height="300"></canvas></div></div></div>'))
                    $('#report').append($('<div class="col-md-6 col-sm-12"><div class="card"><div class="header text-center">NUMBER OF FAILED STUDENTS</div><div class="body"><canvas id="failed" height="300"></canvas></div></div></div>'))

                    response.data.forEach(each=>{
                        labels.push(each.title)
                        colors.push(randomColor())
                    })
                    config1 = {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: response.data,
                                backgroundColor: colors,
                                hoverOffset: 8,
                            }]
                        },
                        options: {
                            responsive: true,
                            parsing:{
                                key: 'total',
                            }
                        }
                    }
                    new Chart($('#numStudents'),config1)

                    config2 ={
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Number of failed students of each faculty',
                                data: response.data,
                                backgroundColor: colors,
                            }]
                        },
                        options: {
                            responsive: true,
                            legends: false,
                            parsing:{
                                xAxisKey: 'title',
                                yAxisKey: 'failed',
                            }
                        }
                    }
                    new Chart($('#failed'),config2)
                @endif
                @if($type == 'major')
                    $('#report').append($('<div class="col-md-6 col-sm-12"><div class="card"><div class="header text-center">NUMBER STUDENTS</div><div class="body"><canvas id="numStudents" height="300"></canvas></div></div></div>'))
                    $('#report').append($('<div class="col-md-6 col-sm-12"><div class="card"><div class="header text-center" id="status-header"></div><div class="body" id="status-body"><canvas id="status" height="300"></canvas></div></div></div>'))
                    $('#status-header').append($('<div class="row clearfix">' +
                        '<div class="col-6">'+
                        '<div class="form-group m-t-0">'+
                        '<div class="form-line">' +
                        '<select class="form-control show-tick" id="select-semester">'+
                        '<option value="">--Semester--</option>'+
                        @for($semester=1;$semester<=$major->semester();$semester++)
                            '<option value="{{$semester}}"> Semester {{$semester}}</option>'+
                        @endfor
                            '</select>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-6">'+
                        '<div class="form-group m-t-0">'+
                        '<div class="form-line">'+
                        '<select class="form-control show-tick" id="select-subject">'+
                        '<option value="">--All Subjects--</option>'+
                        '</select>' +
                        '</div>'+
                        '</div>' +
                        '</div>'+
                        '</div>'))
                response.data.forEach(each=>{
                    labels.push(each.title)
                    colors.push(randomColor())
                })
                config1 = {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: response.data,
                            backgroundColor: colors,
                            hoverOffset: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        parsing:{
                            key: 'total',
                        }
                    }
                }
                new Chart($('#numStudents'),config1)
                let subjects = @json($major->subject);

                let status;

                $('#select-semester').on('change',function () {
                    $('#status').remove();
                    $('#status-body').append($('<canvas id="status" height="300"></canvas>'))
                    let selected = $(this).find('option:selected').val()
                    let majorSubjects = @json($major->majorSubject);
                    majorSubjects = majorSubjects.filter(each => each.semester == selected)
                    let subject_ids = majorSubjects.map(each => each.subject_id)
                    let subjectsThisSemester= subjects.filter(each => subject_ids.includes(each.id))
                    $('#select-subject').find('option:not(:first)').remove()
                    subjectsThisSemester.forEach(each =>{
                        $('#select-subject').append($('<option value="'+each.name+'"> '+each.name+'</option>'))
                    })
                    status = response.data.map(each => {
                        return {title: each.title, status: each.status[selected-1]}
                    })

                    config2 = {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Passed',
                                    data: status,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        yAxisKey: 'status.passed',
                                    }
                                },
                                {
                                    label: 'Failed',
                                    data: status,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        yAxisKey: 'status.failed',
                                    }
                                },
                                {
                                    label: 'In Process',
                                    data: status,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        yAxisKey: 'status.inProcess',
                                    }
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            legends: false,
                            parsing: {
                                xAxisKey: 'title',
                            }
                        }
                    }
                    new Chart($('#status'),config2)
                })

                $('#select-subject').on('change',function (){
                    let selected = $(this).find('option:selected').val()
                    let bySubject = status.map(each => {
                        return {title: each.title, bySubject: Array.isArray(each.status)===false?each.status.bySubject.filter(subject => subject.name==selected)[0]:['No Information']}
                    })
                    config2 = {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Passed',
                                    data: bySubject,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        yAxisKey: 'bySubject.passed',
                                    }
                                },
                                {
                                    label: 'Failed',
                                    data: bySubject,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        yAxisKey: 'bySubject.failed',
                                    }
                                },
                                {
                                    label: 'In Process',
                                    data: bySubject,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        yAxisKey: 'bySubject.inProcess',
                                    }
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            legends: false,
                            parsing: {
                                xAxisKey: 'title',
                            }
                        }
                    }
                    $('#status').remove();
                    $('#status-body').append($('<canvas id="status" height="300"></canvas>'))
                    new Chart($('#status'),config2)
                })
                @endif
                @if($type == 'class')
                $('#report').append($('<div class="col-6"><div class="card"><div class="header text-center">STATUS EACH SEMESTER</div><div class="body"><canvas id="semesters-status" height="300"></canvas></div></div></div>'))
                $('#report').append($('<div class="col-6"><div class="card"><div class="header text-center" id="status-header"></div><div class="body" id="status-body"><canvas id="status" height="300"></canvas></div></div></div>'))
                $('#status-header').append($('<div class="row clearfix">' +
                    '<div class="col-6">'+
                    '<div class="form-group m-t-0">'+
                    '<div class="form-line">' +
                    '<select class="form-control show-tick" id="select-semester">'+
                    '<option value="">--Semester--</option>'+
                    @for($semester=1;$semester<=$class->major->semester();$semester++)
                        '<option value="{{$semester}}"> Semester {{$semester}}</option>'+
                    @endfor
                        '</select>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'))
                response.status.forEach(function (value,index) {
                    if(Array.isArray(value)) labels.push('Semester '+(index+1)+ ' (No Information)')
                    else labels.push('Semester '+(index+1))
                    colors.push(randomColor())
                })
                config1 = {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Passed',
                                data: response.status,
                                backgroundColor: randomColor(),
                                parsing:{
                                    yAxisKey: 'passed',
                                }
                            },
                            {
                                label: 'Failed',
                                data: response.status,
                                backgroundColor: randomColor(),
                                parsing:{
                                    yAxisKey: 'failed',
                                }
                            },
                            {
                                label: 'In Process',
                                data: response.status,
                                backgroundColor: randomColor(),
                                parsing:{
                                    yAxisKey: 'inProcess',
                                }
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        legends: false,
                        parsing:{
                            xAxisKey: 'semester',
                        }
                    }
                }
                new Chart($('#semesters-status'),config1)

                $('#select-semester').on('change',function () {
                    $('#status').remove();
                    $('#status-body').append($('<canvas id="status" height="300"></canvas>'))
                    let selected = $(this).find('option:selected').val()

                    let bySubject = response.status[selected-1].bySubject

                    config2 = {
                        type: 'bar',
                        data: {
                            datasets: [
                                {
                                    label: 'Passed',
                                    data: bySubject,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        xAxisKey: 'passed',
                                    }
                                },
                                {
                                    label: 'Failed',
                                    data: bySubject,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        xAxisKey: 'failed',
                                    }
                                },
                                {
                                    label: 'In Process',
                                    data: bySubject,
                                    backgroundColor: randomColor(),
                                    parsing:{
                                        xAxisKey: 'inProcess',
                                    }
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            legends: false,
                            parsing: {
                                yAxisKey: 'name',
                            },
                            indexAxis: 'y',
                        }
                    }
                    new Chart($('#status'),config2)
                })

                @endif
            }
        })
    </script>

@endpush
