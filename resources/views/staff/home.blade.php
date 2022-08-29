@extends('layouts.staff.master')

@section('title','Dashboard')

@section('section-content-class','home')

@section('content-header')
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@section('content')
    <div class="row clearfix top-report">
        <x-topreportcard>
            <x-slot name="quantity">{{\App\Models\Student::all()->count()}}</x-slot>
            <x-slot name="title">The number of Student</x-slot>
        </x-topreportcard>

        <x-topreportcard>
            <x-slot name="quantity">{{\App\Models\Lecturer::all()->count()}}</x-slot>
            <x-slot name="title">The number of Lecturer</x-slot>
        </x-topreportcard>

        <x-topreportcard>
            <x-slot name="quantity">{{\App\Models\AcademicStaff::all()->count()}}</x-slot>
            <x-slot name="title">The number of Staff</x-slot>
        </x-topreportcard>

        <x-topreportcard>
            <x-slot name="quantity">{{\App\Models\Faculty::all()->count()}}</x-slot>
            <x-slot name="title">The number of Faculty</x-slot>
        </x-topreportcard>
    </div>


    <span>Chart Demo - Develop later</span>
    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="header">
                    <h2>University Earnings</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <canvas id="line_chart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="header">
                    <h2>Student Passing</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <canvas id="bar_chart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        var realtime = 'on';
        "use strict";
        $(function () {
            new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
            new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));

        });

        function getChartJs(type) {
            var config = null;

            if (type === 'line') {
                config = {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            data: [66, 59, 80, 72, 56, 55, 54],
                            borderColor: 'rgba(0, 188, 212, 0.75)',
                            backgroundColor: 'rgba(0, 188, 212, 0.3)',
                            pointBorderColor: 'rgba(0, 188, 212, 0)',
                            pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                            pointBorderWidth: 1
                        }, {
                            label: "My Second dataset",
                            data: [28, 48, 40, 32, 80, 50, 89],
                            borderColor: 'rgba(233, 30, 99, 0.75)',
                            backgroundColor: 'rgba(233, 30, 99, 0.3)',
                            pointBorderColor: 'rgba(233, 30, 99, 0)',
                            pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                            pointBorderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'bar') {
                config = {
                    type: 'bar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            data: [55, 69, 70, 81, 56, 55, 82],
                            backgroundColor: '#dd5e89'
                        }, {
                            label: "My Second dataset",
                            data: [28, 48, 51, 19, 86, 32, 81],
                            backgroundColor: '#f7bb97'
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }

            return config;
        }
    </script>
@endpush

