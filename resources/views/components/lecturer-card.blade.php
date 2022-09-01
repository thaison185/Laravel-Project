<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
    <div class="card">
        <div class="body">
            <div class="member-card verified">
                <div class="thumb-xl member-thumb">
                    <img src="{{$avatar}}" class="img-thumbnail rounded-circle" alt="profile-image" style="object-fit: cover; height:100%">
                </div>

                <div class="m-t-20">
                    <h4 class="m-b-0">{{$name}}</h4>
                    <p class="text-muted">ID: {{$id}}<br><span>{{$faculty}}</span></p>
                </div>

                <p class="text-muted">{{$title}} <br> {{$degree}}</p>
                <a href="{{route('staff.lecturers.one',['id'=>$id])}}"  class="btn btn-sm btn-raised btn-info">View Profile</a>
                @if(auth()->user()->role=='1')
                <button data-href="{{route('staff.lecturers.delete',['id'=>$id])}}" class="btn btn-raised btn-sm btn-danger waves-effect delete-button">Delete</button>
                @endif
            </div>
        </div>
    </div>
</div>
