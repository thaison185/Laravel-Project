@extends('layouts.staff.master')

@section('title','All Staff')

@section('content-header')
    <div class="block-header">
        <h2>All Staff</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@section('content')
    <div class="row m-b-10">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="btn-group float-right m-r-20">
                    <button type="button" class="btn btn-raised bg-blush waves-effect">
                        Add staff
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
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
            </x-staffcard>
        @endforeach
    </div>
    <ul class="p-b-10 pagination justify-content-center" >
        {{$staff->links()}}
    </ul>
@endsection

