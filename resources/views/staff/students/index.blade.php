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
                                        <select class="form-control show-tick" name="faculty" >
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
                                        <select class="form-control show-tick" name="class" >
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
    <div class="row clearfix">
        @foreach($students as $student)
            <div>{{$student->name}}</div>
        @endforeach
    </div>
    <ul class="p-b-10 pagination justify-content-center" >
        {{$students->links()}}
    </ul>
@endsection
