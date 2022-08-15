<!--Side menu -->
<section>
    <!-- Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="admin-image"> <img src="
                @if(auth()->user()->avatar=='') {{asset('img/staff/placeholder.jpg')}}
                @else {{asset('img/staff/'.auth()->user()->avatar)}}
                @endif" alt=""> </div>
            <div class="admin-action-info"> <span>Welcome</span>
                <h3>{{auth()->user()->name}}</h3>
                <ul>
                    <li><a data-placement="bottom" title="Go to Profile" href=""><i class="zmdi zmdi-account"></i></a></li>
                    <li><a data-placement="bottom" title="Sign out" href="{{route('logout')}}" ><i class="zmdi zmdi-sign-in"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active open"><a href="index-2.html"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account"></i><span>Lecturers</span> </a>
                    <ul class="ml-menu">
                        <li><a href="professors.html">All Lecturers</a></li>
                        <li><a href="add-professors.html">Add lecturers</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-outline"></i><span>Students</span> </a>
                    <ul class="ml-menu">
                        <li><a href="students.html">All Students</a></li>
                        <li><a href="add-students.html">Add Students</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-graduation-cap"></i><span>Subjects</span> </a>
                    <ul class="ml-menu">
                        <li><a href="courses.html">All Courses</a></li>
                        <li><a href="add-courses.html">Add Courses</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-city-alt"></i><span>Departments</span> </a>
                    <ul class="ml-menu">
                        <li><a href="departments.html">All Departments</a></li>
                        <li><a href="add-departments.html">Add Departments</a></li>
                    </ul>
                </li>
{{--                <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-mood"></i><span>Staffs</span> </a>--}}
{{--                    <ul class="ml-menu">--}}
{{--                        <li><a href="staffs.html">All Staffs</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li><a href="centres.html"><i class="zmdi zmdi-pin"></i><span>About University</span></a></li>
            </ul>
        </div>
        <!-- #Menu -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
<!--Side menu -->
