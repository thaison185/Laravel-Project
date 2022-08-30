<div class="col-lg-6 col-md-12 col-sm-12">
    <div class="card">
        <div class="body">
            <div class="member-card row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="member-thumb m-b-20">
                        <img src="{{$avatar}}" class="img-thumbnail rounded-circle" alt="profile-image">
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="s-profile">
                        <h4 class="m-b-0">{{$name}}</h4>
                            <p class="">@if($role=='1')Administrator @else Staff @endif<span> <a href="mailto:{{$email}}" class="text-pink">Email: {{$email}}</a> </span></p>
                            <p>ID: {{$id}}</p>
                        <a href="{{route('staff.students.one',['id'=>$id])}}"  class="btn btn-raised btn-sm btn-default waves-effect">View Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
