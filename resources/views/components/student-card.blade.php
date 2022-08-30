<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card all-patients">
        <div class="body">
            <div class="row">
                <div class="col-lg-4 col-md-12 m-b-0">
                    <a href="#" class="p-profile-pix"><img src="{{$avatar}}" alt="user" class="img-thumbnail img-fluid"></a>
                </div>
                <div class="col-lg-8 col-md-12 m-b-0">
                    <h5 class="m-b-0">{{$name}} <a href="{{route('staff.students.one',['id'=>$id])}}" class="edit" style="float:right"><i class="zmdi zmdi-edit"></i></a></h5> <small>{{$major}}<br>{{$class}}</small>
                    <div class="m-t-10 m-b-0">
                        Email: {{$email}}<br>
                        <abbr title="Phone">P:</abbr> {{$phone}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
