<!--Side menu -->
<section>
    <!-- Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="admin-image"> <img src="
                @if(auth()->user()->avatar=='') {{asset('img/staff/placeholder.jpg')}}
                @else {{asset('storage/'.auth()->user()->avatar)}}
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
                <li id="home-tag"><a href="{{route('staff.home')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                <li class="li-parent"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account"></i><span>Lecturers</span> </a>
                    <ul class="ml-menu">
                        <li id="lecturers"><a href="{{route('staff.lecturers.all')}}">All Lecturers</a></li>
                        <li id="add-lecturer"><a href="{{route('staff.lecturers.create')}}">Add Lecturer</a></li>
                        <li id="import-lecturers"><a href="{{route('staff.lecturers.import-index')}}">Import Lectures</a></li>
                    </ul>
                </li>
                <li class="li-parent"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-outline"></i><span>Students</span> </a>
                    <ul class="ml-menu">
                        <li id="students"><a href="{{route('staff.students.all')}}">All Students</a></li>
                        <li id="add-student"><a href="{{route('staff.students.create')}}">Add Student</a></li>
                        <li id="import-students"><a href="{{route('staff.students.import-index')}}">Import Students</a></li>
                    </ul>
                </li>
                <li class="li-parent"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-graduation-cap"></i><span>Subjects & Majors</span> </a>
                    <ul class="ml-menu">
                        <li id="subjects"><a href="{{route('staff.subject-major.subjects')}}">All Subjects</a></li>
                        <li id="majors"><a href="{{route('staff.subject-major.majors')}}">All Majors</a></li>
                    </ul>
                </li>
                <li class="li-parent"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-city-alt"></i><span>Faculties & Classes</span> </a>
                    <ul class="ml-menu">
                        <li id="faculties"><a href="{{route('staff.faculty-class.faculties')}}">All Faculties</a></li>
                        <li id="classes"><a href="{{route('staff.faculty-class.classes')}}">All Classes</a></li>
                    </ul>
                </li>
                <li class="li-parent"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-mood"></i><span>Staff</span> </a>
                    <ul class="ml-menu">
                        <li id="staff"><a href="{{route('staff.staff.all')}}">All Staff</a></li>
                    </ul>
                </li>
                <li class="about"><a href="centres.html"><i class="zmdi zmdi-pin"></i><span>About University</span></a></li>
            </ul>
        </div>
        <!-- #Menu -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
<!--Side menu -->
