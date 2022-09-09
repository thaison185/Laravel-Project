@extends('layouts.staff.master')

@section('title','Academic Performance')

@section('content-header')
    <div class="block-header">
        <h2>Academic Performance</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class=" card" id="avatar-thumb">
                    <img src="
                    @if($student->avatar=='') {{asset('img/staff/placeholder.jpg')}}
                    @else {{asset('storage/'.$student->avatar)}}
                    @endif" alt="" style="object-fit:cover;height:100%;width:100%" >
                </div>
                <div class="card">
                    <div class="header">
                        <h2>About Students</h2>
                    </div>
                    <div class="body" id="basic-info">
                        <strong>Name</strong>
                        <p>{{$student->name}}</p>
                        <strong>Major</strong>
                        <p>{{$student->major->name}}</p>
                        <strong>Email</strong>
                        <p><a href="mailto:{{$student->email}}">{{$student->email}}</a></p>
                        <strong>Phone</strong>
                        <p>+84 {{$student->phone}}</p>
                        <hr>
                        <strong>Description</strong>
                        <p>{{nl2br($student->description)}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="report">
                                <div class="wrap-reset">
                                    <div class="post-box">
                                        <div class="text-center">
                                            <h4>Academic Performance</h4>
                                        </div>
                                        <div>
                                            @for($each=1;$each<=$student->classs->major->semester();$each++)
                                                <div data-toggle="collapse" class="accordion-toggle text-center py-2 @if($each%2==0) bg-teal @else bg-cyan @endif"
                                                     data-target="#semester{{$each}}" role="button" >
                                                    Semester #{{$each}}
                                                </div>
                                                <div class="accordian-body collapse" id="semester{{$each}}">
                                                    <table class="table table-bordered table-striped table-hover m-b-0" id="table-semester{{$each}}">
                                                        <thead>
                                                        <th scope="col">Subject</th>
                                                        <th scope="col">Lecture Hour</th>
                                                        <th scope="col">Lecturer</th>
                                                        <th scope="col">Exam Date</th>
                                                        <th scope="col">Score</th>
                                                        <th scope="col">Status</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($student->assignmentsInSemester($each) as $assignment)
                                                            <tr>
                                                                <td>{{$assignment->majorSubject->subject->name}}</td>
                                                                <td>{{$assignment->majorSubject->lecture_hour}}</td>
                                                                <td>{{$assignment->lecturer->name}}</td>
                                                                <td>{{$student->performance($assignment->id)??''}}</td>
                                                                <td>{{$student->performance($assignment->id)??''}}</td>
                                                                <td>
                                                                    @if(empty($student->performance($assignment->id)))
                                                                        <i class="text-muted">In process...</i>
                                                                    @else
                                                                        @if($student->performance($assignment->id)->score < 7)
                                                                            <i class="text-danger">Failed</i>
                                                                        @else <i class="text-success">Passed</i>
                                                                        @endif
                                                                    @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
