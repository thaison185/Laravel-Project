@extends('layouts.staff.master')

@section('title','All Subjects')

@section('content-header')
    <div class="block-header">
        <h2>All Subjects</h2>
        <small class="text-muted">X University Application</small>
    </div>
@endsection

@section('content')
    @if(auth()->user()->role=='1')
        <div class="row m-b-10">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="btn-group float-right m-r-20">
                        <button type="button"
                                class="btn btn-raised bg-blush waves-effect"
                                data-toggle="modal" data-target="#Modal" data-type="add"
                                data-action="{{route('staff.subject-major.storeSubject')}}">
                            Add Subject
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="reload">
        <div class="row clearfix" id="subjects">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-light">
                            <tr class="g-bg-blush2">
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col" class="text-center">Name</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="tbody">
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td class="text-center">{{$subject->id}}</td>
                                        <td class="text-center">{{$subject->name}}</td>
                                        <td class="text-center">{{$subject->description}}</td>
                                        <td class="text-center">
                                            <button type="button"
                                                    data-action="{{route('staff.subject-major.updateSubject',['id'=>$subject->id])}}"
                                                    data-name="{{$subject->name}}"
                                                    data-description="{{$subject->description}}"
                                                    data-toggle="modal" data-target="#Modal"
                                                    data-type="update"
                                                    data-id="{{$subject->id}}"
                                                    class="btn btn-circle waves-effect waves-circle waves-float"><i class="zmdi zmdi-edit text-info"></i>
                                            </button>
                                            @if(auth()->user()->role=='1')
                                                <button data-href="{{route('staff.subject-major.deleteSubject',['id'=>$subject->id])}}"
                                                        data-toggle="modal" data-target="#DeleteModal"
                                                        class="btn btn-circle waves-effect waves-float waves-circle"><i class="zmdi zmdi-delete text-danger"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <ul class="p-b-10 pagination justify-content-center" >
                            {{$subjects->links()}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
        <form method="post" id="update-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-col-blue-grey">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel"></h4>
                    </div>
                    <div class="modal-body append-here">
                        <div class="row clearfix">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control text-white" name="name" placeholder="Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="4" class="form-control no-resize text-white" placeholder="Description..." name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="reset" class="btn btn-link waves-effect" data-dismiss="modal" id="close-ava">CLOSE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-col-teal">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Delete Subject</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix text-center">
                        <p>Do you really want to delete this Subject?</p>
                        <p><small><i>Using <b>Force Delete</b> to delete all related records belong to in this Subject</i></small></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger text-white waves-effect mx-1 mt-2 btn-delete" data-type="force">FORCE DELETE</button>
                    <button class="btn btn-warning text-white waves-effect mx-1 mt-2 btn-delete">DELETE</button>
                    <button class="btn btn-default waves-effect mx-1 mt-2" data-dismiss="modal" id="close-button">CANCEL</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('/staff-asset/plugins/jquery-validation/jquery.validate.js')}}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('staff-asset/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('/staff-asset/js/pages/ui/notifications.js')}}"></script>

    {{--    Reset field     --}}
    <script>
        $(function (){
            $("#Modal").on('hide.bs.modal', function (){
                $(this).find('form')[0].reset();
            });
        });
    </script>
    {{--    Modal   --}}
    <script>
        $('#Modal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let modal = $(this);
            modal.find('form').attr('action',button.data('action'));
            if(button.data('type')=='update'){
                modal.find('.append-here').append($('<input type="hidden" name="type" value="update" class="type">'));
                modal.find('input[name="name"]').val(button.data('name'));
                modal.find('textarea[name="description"]').val(button.data('description'));
                $('#defaultModalLabel').text('Update Subject #'+button.data('id'))
            }else{
                modal.find('.append-here').append($('<input type="hidden" name="type" value="add" class="type">'));
                $('#defaultModalLabel').text('Add Subject')
            }
        });

        $('#DeleteModal').on('show.bs.modal',function (event){
            let button = $(event.relatedTarget);
            let modal=$(this);
            $('.btn-delete').attr('data-href',button.data('href'));
        })
    </script>
    {{--    Input fields validate      --}}
    <script>
        $(function () {
            $('#update-form').validate({
                rules: {
                    'name': {
                        maxlength: 50,
                    }
                },
                highlight: function (input) {
                    $(input).parents('.form-line').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.form-line').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-group').append(error);
                },
            });
        });
    </script>
    {{--    Ajax Form Submit    --}}
    <script>
        $(function () {
            $("#update-form").submit(function (e) {
                e.preventDefault();
                let actURL = $(this).attr("action");
                const formData = new FormData(this);
                if ($(this).valid()) {
                    callAJAX(actURL, formData);
                }
            });

            $(document).on('click','.btn-delete',function(){
                const formData = new FormData();
                formData.append('_token','{{csrf_token()}}');
                formData.append('type',$(this).data('type'));
                let actURL = $(this).data('href');
                callAJAX(actURL,formData);
            })

            function callAJAX(actURL,formData){
                $.ajax({
                    type: "POST",
                    url: actURL,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==="success"){
                            $("#close-ava").click();
                            showNotification('g-bg-cgreen',response.message,'top','center','animated fadeInDown','animated fadeOutDown');
                            $("#reload").load(document.URL+' #reload');
                        }else{
                            showNotification('g-bg-soundcloud',response.message,'top','center','animated zoomInDown','animated zoomOutUp');
                        }
                    },
                    error: function (response){
                        let error ='';
                        if(response.responseJSON.errors){
                            let errors = Object.values(response.responseJSON.errors);
                            if(Array.isArray(errors)){
                                errors.forEach(function (each){
                                    each.forEach(function(message){
                                        error+=`${message}<br>`;
                                    });
                                });
                            }
                            else{
                                error+=`${errors}`;
                            }
                        }
                        else {
                            error = response.responseJSON.message;
                        }
                        showNotification('g-bg-soundcloud',error,'top','center','animated zoomInDown','animated zoomOutUp');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: "multipart/form-data",
                    async: false,
                });
            }
            $(document).on('click','.delete-button',function (){
                if (confirm("You really want to delete this subject?") === true) {
                    const formData = new FormData();
                    formData.append('_token','{{csrf_token()}}');
                    let actURL = $(this).data('href');
                    callAJAX(actURL,formData);
                }
            });
        });
    </script>
@endpush
