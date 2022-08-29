@extends('layouts.staff.master')

@section('title','All Lecturers')

@section('content-header')
    <div class="block-header">
        <h2>All Lecturers</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@section('content')
    <div class="row m-b-10">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="body">
                    <form action="{{route('staff.lecturers.all')}}" method="post">
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
                                            <option value="" @if($filter=='') selected @endif>All Faculties</option>
                                            @foreach($faculties as $faculty)
                                                <option value="{{$faculty->id}}" @if($filter==$faculty->id) selected @endif>
                                                    {{$faculty->id.'. '.$faculty->name}}
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
                                        Add Lecturers
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('staff.lecturers.create')}}">Manually</a></li>
                                        <li><a href="{{route('staff.lecturers.import-index')}}">Import CSV</a></li>
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
        @foreach($lecturers as $lecturer)
            <x-lecturercard>
                <x-slot name="avatar">
                    @if($lecturer->avatar=='') {{asset('/img/staff/placeholder.jpg')}}
                    @else {{asset('storage/'.$lecturer->avatar)}}
                    @endif
                </x-slot>
                <x-slot name="id">{{$lecturer->id}}</x-slot>
                <x-slot name="faculty">
                    {{$lecturer->faculty->name}}
                </x-slot>
                <x-slot name="name">
                    {{$lecturer->name}}
                </x-slot>
                <x-slot name="title">
                    {{$lecturer->title}}
                </x-slot>
                <x-slot name="degree">
                    {{$lecturer->degree}}
                </x-slot>
                <x-slot name="id">{{$lecturer->id}}</x-slot>
            </x-lecturercard>
        @endforeach
    </div>
    <ul class="p-b-10 pagination justify-content-center" >
        {{$lecturers->links()}}
    </ul>
@endsection
