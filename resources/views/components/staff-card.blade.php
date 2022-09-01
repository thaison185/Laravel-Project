<div class="col-lg-6 col-md-12 col-sm-12" id="staff-{{$id}}">
    <div class="card">
        <div class="body">
            <div class="member-card row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="thumb-xl member-thumb m-b-20">
                        <img src="{{$avatar}}" class="img-thumbnail rounded-circle" alt="profile-image" style="object-fit: cover; height:100%">
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="s-profile">
                        <h4 class="m-b-0">{{$name}}</h4>
                            <p class="">@if($role=='1')Administrator @else Staff @endif<span> <a href="mailto:{{$email}}" class="text-pink">Email: {{$email}}</a> </span></p>
                            <p>ID: {{$id}}</p>
                        @if(auth()->user()->role=='1')
                            <button type="button"
                                    data-action="{{route('staff.staff.update',['id'=>$id])}}"
                                    data-lastname="{{explode(' ',$name)[0]}}"
                                    data-firstname="{{implode(' ',array_slice(explode(' ',$name),1))}}"
                                    data-gender="{{$gender}}"
                                    data-role="{{$role}}"
                                    data-toggle="modal" data-target="#Modal"
                                    data-type="update"
                                    class="btn btn-raised btn-sm btn-info waves-effect">Update Profile</button>
                            <button data-href="{{route('staff.staff.delete',['id'=>$id])}}" class="btn btn-raised btn-sm btn-danger waves-effect delete-button">Delete</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

