@extends('layouts.login')

@section('role','staff')

@section('warn')
    <div class="text-center">
        <p style="color: #333; font-size:12px; padding: 4px;">
            If you are not a Staff of X University, please go to the sign-in page for <a href="{{route('login')}}">students or lecturers</a>
        </p>
    </div>
@endsection
