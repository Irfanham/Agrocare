@extends('farmer.layouts.app') @section('content')
<div class="card bg-light mb-3">
    <div class="card-body">
        <form enctype="multipart/form-data">
            <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}" />

            <div class="form-group">
                <textarea id="content" class="form-control" rows="5" placeholder="Apa yang Anda pikirkan ?"></textarea>
            </div>
            <div class="photos" style="overflow-x: auto;overflow-y: hidden;width: 100%;white-space: nowrap"></div>
            <div class="form-group">
                <div class="w-100">

                    <input type="file" id="image-status" name="image" style="display: none;" />
                    <i id="status-image"" role=" button" class="fa fa-image fa-lg btn btn-link w-100 text-dark px-0">
                    </i>
                </div>

                <button type="submit" id="submitFeed" class="btn btn-primary float-right">
                    Publish
                </button>
            </div>
        </form>

    </div>
</div>

<div class="mb-3" id="content-feed">
    @foreach($status as $data)
    @php
    $like = DB::table('reactions')->where('post_id', $data->id)->get();
    $liker_user = DB::table('reactions')->where('post_id', $data->id)->where('user_id', Auth::user()->id)->first();
    $comments = DB::table('comments')->leftjoin('users', 'comments.user_id', '=', 'users.id')->select('comments.*',
    'users.name', 'users.photo_profile')->where('post_id', $data->id)->orderBy('id', 'desc')->get();
    @endphp
    <div class="card bg-light mb-3 my-4" id="{{'post'.$data->id}}">
        <div class="card-header d-flex mt-1">

            {{-- heading options --}}
            <div class="d-flex align-items-center">
                <a href="{{ route('farmer.profileuser',$data->user_id) }}">
                    <img src="{{
                        asset('storage/img/'.$data->users->photo_profile)
                    }}" alt="" class="rounded-circle" style="width: 50px; height:50px">
                </a>
                <d iv class="ms-3 ml-2">
                    <a href="{{ route('farmer.profileuser',$data->user_id) }}">
                        <h5 class="card-title text-dark">{{ $data->users->name }}
                        </h5>
                    </a>
                    <small class="card-subtitle mb-2 text-muted">
                        {{ $data->created_at->diffForHumans() }}
                    </small>
            </div>
        </div>
        <div class="card-body py-3">
            <p class="card-text">{{$data->content}}</p>
        </div>
        @if($data->image)
        <img class="post_img" src="{{
                asset('storage/'.$data->image)
            }}" alt="status-image" />
        @endif

        <div class="card-footer d-flex justify-content-around p-1">
            <div class="w-50">
                @if($liker_user !=null)
                @if(Auth::user()->id==$liker_user->user_id)
                <form action="{{ route('farmer.like.destroy', $liker_user->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-link w-100 text-dark px-0">
                        <i class="fa fa-heart fa-lg text-danger"></i>
                        {{ '(' . $like->count() . ')' }}</button>
                </form>
                @endif
                @else
                <form action="{{ route('farmer.like.store') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="post_id">
                    <button type="submit" id="like-button" class="btn btn-link w-100 text-dark px-0">
                        <i class="fa fa-heart fa-lg fa-lk text-primary"></i> {{ '(' . $like->count() . ')' }}</button>
                </form>
                @endif
            </div>
            <div class="vr"> </div>
            <a class="btn btn-link w-50 text-dark px-0" data-toggle="modal"
                data-target="{{ '#postCmnt' . $data->id }}"><i class="fa fa-comment fa-lg fa-cl"></i> {{ '(' .
                $comments->count() . ')' }}</a>

            <div class="vr">
            </div>
            <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                data-id="{{ $data->id }}" data-toggle="tooltip" title="Edit Status"
                class="btn btn-link w-50 text-dark px-0">
                <i class="fa fa-edit fa-lg"></i>
            </a>
            <a href="javascript:void(0)" id="btn_delete_status" class="btn btn-link w-50 text-dark px-0"
                data-toggle="tooltip" title="Hapus Status" data-id="{{$data->id}}">
                <i class="fa fa-trash fa-lg"></i>
            </a>

        </div>

        <!-- comment form  -->
        <div class="card-footer d-flex p-2 px-4">
            <img src="{{
                asset('storage/img/'.Auth::user()->photo_profile)
            }}" alt="" class="rounded-circle mr-2" style="width: 40px; height: 40px">
            <div class="ms-3 w-100">
                <form action="{{ route('farmer.comment.store') }}" method="post">
                    @csrf
                    <div class="d-flex">
                        <input type="hidden" name="post_id" value="{{ $data->id }}">

                        <input type="text" class="form-control btn-rounded @error('comment') is-invalid @enderror"
                            name="comment" placeholder="Tulis komentar..." style="border-radius: 1.25rem;">
                        @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                        @enderror

                        <button type="submit" class="btn btn-link ms- p-2"><i
                                class="fa fa-paper-plane fa-lg"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end comment form  -->
    </div>

    <!-- comment modal  -->
    <div class="modal fade" id="{{ 'postCmnt' . $data->id }}" role="dialog" tabindex="-1"
        aria-labelledby="{{ 'postCmnt' . $data->id . 'Label' }}" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog  modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Komentar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="myDataTable table table- table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $cmnt)
                            <tr>
                                <td class="p-0 px-md-3">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('farmer.profileuser',$cmnt->user_id) }}">
                                            <img src="{{ asset('storage/img/').'/'.$cmnt->photo_profile }}" alt=""
                                                class="rounded-circle" style="width: 40px; height:40px">
                                        </a>
                                        <div class="ms-3">
                                            <div class="d-flex mt-3">
                                                <a href="{{ route('farmer.profileuser',$cmnt->user_id) }}">
                                                    <h6 class="">{{ $cmnt->name }}
                                                    </h6>
                                                </a>
                                                <small class="text-muted ms-2">
                                                    <i> ({{ date('d F, y | h:i A', strtotime($cmnt->c_date)) }})</i>
                                                </small>
                                            </div>
                                            <p>{{ $cmnt->comment }}</p>
                                        </div>
                                        @if (Auth::user()->id == $cmnt->user_id)
                                        <div class="ms-auto text-end">
                                            <form action="{{ route('farmer.comment.destroy', $cmnt->id) }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="delete btn btn-link text-danger p-0"><i
                                                        class="fa fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- comment form -->
                    <div class="card-footer d-flex p-2 pt-3 px-4">
                        <img src="{{
                 asset('storage/img/'.Auth::user()->photo_profile)
             }}" alt="" class="rounded-circle mr-2" style="width: 40px; height: 40px">
                        <div class="ms-3 w-100">
                            <form action="{{ route('farmer.comment.store') }}" method="post">
                                @csrf
                                <div class="d-flex">
                                    <input type="hidden" name="post_id" value="{{ $data->id }}">

                                    <input type="text"
                                        class="form-control btn-rounded @error('comment') is-invalid @enderror"
                                        name="comment" placeholder="Tulis komentar..." style="border-radius: 1.25rem;">
                                    @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <button type="submit" class="btn btn-link ms- p-2"><i
                                            class="fa fa-paper-plane fa-lg"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end form -->
                </div>
            </div>
        </div>
    </div>

    <!-- end modal -->

    @endforeach
</div>




<!-- Edit status Modal -->
<div class="modal fade" id="editModalStatus" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    Edit Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="statusDataEdit">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="status_id" name="status_id" value="" />
                        <label for="editContent">Status</label>
                        <textarea class="form-control" id="content_edit" rows="5"></textarea>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-content-edit">
                        </div>
                        <label for="editImage">Gambar</label>
                        <img src="" alt="status-image" class="form-control" id="image_edit"
                            style="width:50%;height: 50%;">
                        <input type="file" id="editstatus-image" name="image" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Keluar
                        </button>
                        <button type="submit" id="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>


@endsection @section('side')

<div class="card bg-light mb-3">
    <div class="card-header text-center">Teman</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @foreach($friend as $value)
            @foreach($value->follows as $friend)
            <a href="#" class="list-group-item nav-link text-justify"
                style="color:rgba(0, 0, 0, 0.5);">{{$friend->name}}
                <span style="
                position: absolute;
                left: 0px;
            ">&bull;</span>
                <p class="card-text" style="color:rgba(0, 0, 0, 0.5);">&#64;{{$friend->username}}</p>
            </a>
            @endforeach
            @endforeach
        </div>
    </div>
</div>
<div class="card bg-light mb-3">
    <div class="card-header text-center">Konsultan</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @foreach($consult as $ta)
            <a href="{{url('konsultasi'.'/'.$ta->id)}}" class="list-group-item nav-link"
                style="color:rgba(0, 0, 0, 0.5);">{{$ta->name}}
                <span style="
                position: absolute;
                left: 0px;
            ">&bull;</span>
                <p class="card-text" style="color:rgba(0, 0, 0, 0.5);">&#64;{{$ta->username}}</p>
            </a>

            @endforeach
        </div>
    </div>
</div>

@endsection @section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        //chooseimage
        $("#status-image").click(function () {
            $("input[id='image-status']").click();
        });





        //comment

        //add status
        $('#image-status').change(function (event) {
            var src = URL.createObjectURL(event.target.files[0]);
            $('.photos').empty().append(`
                <img src="${src}" width="60" />
            `);
        });
        $('#submitFeed').on('click', (function (e) {

            e.preventDefault();
            var data = new FormData();
            if (document.getElementById('image-status').files[0] != undefined) {
                var file = document.getElementById('image-status').files[0];
                data.append('image', file);
            }
            var user_id = document.getElementById('user_id').value;
            var content = document.getElementById('content').value;
            data.append('user_id', user_id);
            data.append('content', content);

            let url = '{{route("farmer.addstatusf")}}';
            $.ajax({
                type: 'POST',
                url: url,
                data,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    //show success message
                    Swal.fire({
                        type: "success",
                        icon: "success",
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 1000,
                    });



                    //data status
                    var url1 = '{{route("farmer.profilepage")}}';
                    var id = `${response.data.id}`;
                    if (response.data.image != undefined) {
                        var status = `
                    <div class="card bg-light mb-3 my-4" id="post${response.data.id}">
                        <div class="card-header d-flex mt-1">

                            <div class="d-flex align-items-center">
                                <a href="${url1}">
                                    <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle" style="width: 50px; height:50px">
                                </a>
                                <d iv class="ms-3 ml-2">
                                    <a href="${url1}">
                                        <h5 class="card-title text-dark">${response.user.name}
                                        </h5>
                                    </a>
                                    <small class="card-subtitle mb-2 text-muted">
                                        ${response.date}
                                    </small>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <p class="card-text">${response.data.content}</p>
                        </div>
                        
                        <img class="post_img" src="storage/${response.data.image}" alt="status-image" />
 
                        <div class="card-footer d-flex justify-content-around p-1">
                            <div class="w-50">
                                <button type="submit" id="like-button" class="btn btn-link w-100 text-dark px-0">
                                    <i class="fa fa-heart fa-lg fa-lk text-primary"></i> (0)</button>

                            </div>
                            <div class="vr"> </div>
                            <a class="btn btn-link w-50 text-dark px-0" data-toggle="modal" data-target="#modalComment"><i
                                    class="fa fa-comment fa-lg fa-cl"></i> (0)</a>

                            <div class="vr">
                            </div>
                            <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                                data-id="${response.data.id}" data-toggle="tooltip" title="Edit Status"
                                class="btn btn-link w-50 text-dark px-0">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <a href="javascript:void(0)" id="btn_delete_status" class="btn btn-link w-50 text-dark px-0"
                                data-toggle="tooltip" title="Hapus Status" data-id="${response.data.id}">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                        
                        </div>

                        <div class="card-footer d-flex p-2 px-4">
                            <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle mr-2" style="width: 40px; height: 40px">
                            <div class="ms-3 w-100">
                                <form action="" method="post">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="hidden" name="post_id" value="">

                                        <input type="text" class="form-control btn-rounded @error('comment') is-invalid @enderror"
                                            name="comment" placeholder="Tulis komentar..." style="border-radius: 1.25rem;">
                                        @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                        @enderror

                                        <button type="submit" class="btn btn-link ms- p-2"><i
                                                class="fa fa-paper-plane fa-lg"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    `;
                    } else {
                        var status = `
                    <div class="card bg-light mb-3 my-4" id="post${response.data.id}">
                        <div class="card-header d-flex mt-1">

                            <div class="d-flex align-items-center">
                                <a href="${url1}">
                                    <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle" style="width: 50px; height:50px">
                                </a>
                                <d iv class="ms-3 ml-2">
                                    <a href="${url1}">
                                        <h5 class="card-title text-dark">${response.user.name}
                                        </h5>
                                    </a>
                                    <small class="card-subtitle mb-2 text-muted">
                                        ${response.date}
                                    </small>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <p class="card-text">${response.data.content}</p>
                        </div>
                    
                        <div class="card-footer d-flex justify-content-around p-1">
                            <div class="w-50">
                                <button type="submit" id="like-button" class="btn btn-link w-100 text-dark px-0">
                                    <i class="fa fa-heart fa-lg fa-lk text-primary"></i> (0)</button>

                            </div>
                            <div class="vr"> </div>
                            <a class="btn btn-link w-50 text-dark px-0" data-toggle="modal" data-target="#modalComment"><i
                                    class="fa fa-comment fa-lg fa-cl"></i> (0)</a>

                            <div class="vr">
                            </div>
                            <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                                data-id="${response.data.id}" data-toggle="tooltip" title="Edit Status"
                                class="btn btn-link w-50 text-dark px-0">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <a href="javascript:void(0)" id="btn_delete_status" class="btn btn-link w-50 text-dark px-0"
                                data-toggle="tooltip" title="Hapus Status" data-id="${response.data.id}">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                        
                        </div>

                        <div class="card-footer d-flex p-2 px-4">
                            <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle mr-2" style="width: 40px; height: 40px">
                            <div class="ms-3 w-100">
                                <form action="" method="post">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="hidden" name="post_id" value="">

                                        <input type="text" class="form-control btn-rounded @error('comment') is-invalid @enderror"
                                            name="comment" placeholder="Tulis komentar..." style="border-radius: 1.25rem;">
                                        @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                        @enderror

                                        <button type="submit" class="btn btn-link ms- p-2"><i
                                                class="fa fa-paper-plane fa-lg"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                                    
                    `;
                    }


                    $('#content-feed').prepend(status);

                    //clear form
                    $('#title').val('');
                    $('#content').val('');

                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }));



        //update
        $('#editstatus-image').change(function (event) {
            var src = URL.createObjectURL(event.target.files[0]);
            $('#image_edit').attr('src', src);

        });

        $("body").on("click", "#submit", function (event) {
            event.preventDefault();
            var data = new FormData();
            if (document.getElementById('image_edit').files[0] != undefined) {
                var file = document.getElementById('image_edit').files[0];
                data.append('image', file);
            }
            var id = document.getElementById('status_id').value;
            var content = document.getElementById('content_edit').value;
            data.append('id', id);
            data.append('content', content);
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("farmer.updatestatusf", ":id") }}';
            url = url.replace(":id", id);


            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                success: function (response) {
                    //message
                    Swal.fire({
                        type: "success",
                        icon: "success",
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    //data
                    var url1 = '{{route("farmer.profilepage")}}';
                    var id = `${response.data.id}`;
                    if (response.data.image != undefined) {
                        var status = `
                    <div class="card bg-light mb-3 my-4" id="post${response.data.id}">
                        <div class="card-header d-flex mt-1">

                            <div class="d-flex align-items-center">
                                <a href="${url1}">
                                    <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle" style="width: 50px; height:50px">
                                </a>
                                <d iv class="ms-3 ml-2">
                                    <a href="${url1}">
                                        <h5 class="card-title text-dark">${response.user.name}
                                        </h5>
                                    </a>
                                    <small class="card-subtitle mb-2 text-muted">
                                        ${response.date}
                                    </small>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <p class="card-text">${response.data.content}</p>
                        </div>
                        
                        <img class="post_img" src="storage/img/${response.data.image}" alt="status-image" />
 
                        <div class="card-footer d-flex justify-content-around p-1">
                            <div class="w-50">
                                <button type="submit" id="like-button" class="btn btn-link w-100 text-dark px-0">
                                    <i class="fa fa-heart fa-lg fa-lk text-primary"></i> (0)</button>

                            </div>
                            <div class="vr"> </div>
                            <a class="btn btn-link w-50 text-dark px-0" data-toggle="modal" data-target="#modalComment"><i
                                    class="fa fa-comment fa-lg fa-cl"></i> (0)</a>

                            <div class="vr">
                            </div>
                            <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                                data-id="${response.data.id}" data-toggle="tooltip" title="Edit Status"
                                class="btn btn-link w-50 text-dark px-0">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <a href="javascript:void(0)" id="btn_delete_status" class="btn btn-link w-50 text-dark px-0"
                                data-toggle="tooltip" title="Hapus Status" data-id="${response.data.id}">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                        
                        </div>

                        <div class="card-footer d-flex p-2 px-4">
                            <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle mr-2" style="width: 40px; height: 40px">
                            <div class="ms-3 w-100">
                                <form action="" method="post">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="hidden" name="post_id" value="">

                                        <input type="text" class="form-control btn-rounded @error('comment') is-invalid @enderror"
                                            name="comment" placeholder="Tulis komentar..." style="border-radius: 1.25rem;">
                                        @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                        @enderror

                                        <button type="submit" class="btn btn-link ms- p-2"><i
                                                class="fa fa-paper-plane fa-lg"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    `;
                    } else {
                        var status = `
                    <div class="card bg-light mb-3 my-4" id="post${response.data.id}">
                        <div class="card-header d-flex mt-1">

                            <div class="d-flex align-items-center">
                                <a href="${url1}">
                                    <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle" style="width: 50px; height:50px">
                                </a>
                                <d iv class="ms-3 ml-2">
                                    <a href="${url1}">
                                        <h5 class="card-title text-dark">${response.user.name}
                                        </h5>
                                    </a>
                                    <small class="card-subtitle mb-2 text-muted">
                                        ${response.date}
                                    </small>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <p class="card-text">${response.data.content}</p>
                        </div>
                    
                        <div class="card-footer d-flex justify-content-around p-1">
                            <div class="w-50">
                                <button type="submit" id="like-button" class="btn btn-link w-100 text-dark px-0">
                                    <i class="fa fa-heart fa-lg fa-lk text-primary"></i> (0)</button>

                            </div>
                            <div class="vr"> </div>
                            <a class="btn btn-link w-50 text-dark px-0" data-toggle="modal" data-target="#modalComment"><i
                                    class="fa fa-comment fa-lg fa-cl"></i> (0)</a>

                            <div class="vr">
                            </div>
                            <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                                data-id="${response.data.id}" data-toggle="tooltip" title="Edit Status"
                                class="btn btn-link w-50 text-dark px-0">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <a href="javascript:void(0)" id="btn_delete_status" class="btn btn-link w-50 text-dark px-0"
                                data-toggle="tooltip" title="Hapus Status" data-id="${response.data.id}">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                        
                        </div>

                        <div class="card-footer d-flex p-2 px-4">
                            <img src="storage/img/${response.user.photo_profile}" alt="" class="rounded-circle mr-2" style="width: 40px; height: 40px">
                            <div class="ms-3 w-100">
                                <form action="" method="post">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="hidden" name="post_id" value="">

                                        <input type="text" class="form-control btn-rounded @error('comment') is-invalid @enderror"
                                            name="comment" placeholder="Tulis komentar..." style="border-radius: 1.25rem;">
                                        @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                        @enderror

                                        <button type="submit" class="btn btn-link ms- p-2"><i
                                                class="fa fa-paper-plane fa-lg"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                                    
                    `;
                    }

                    //append to status data
                    $(`#index_${response.data.id}`).replaceWith(status);

                    //modal hide
                    $("#editModalStatus").modal("hide");
                },

                error: function (error) {
                    if (error.responseJSON.title[0]) {
                        //show alert
                        $("#alert-title-edit").removeClass("d-none");
                        $("#alert-title-edit").addClass("d-block");

                        //add message to alert
                        $("#alert-title-edit").html(error.responseJSON.name[0]);
                    }

                    if (error.responseJSON.content[0]) {
                        //show alert
                        $("#alert-content-edit").removeClass("d-none");
                        $("#alert-content-edit").addClass("d-block");

                        //add message to alert
                        $("#alert-content-edit").html(
                            error.responseJSON.content[0]
                        );
                    }

                },
            });
        });

        //show edit
        $("body").on("click", "#btn_edit_status", function (event) {
            let id = $(this).data("id");
            var url = '{{ route("farmer.showstatusf", ":id") }}';
            url = url.replace(":id", id);


            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                dataType: "json",
                success: function (response) {

                    if (response.data.image != undefined) {
                        $("#status_id").val(response.data.id);
                        $("#content_edit").val(response.data.content);
                        $('#image_edit').attr('src', 'storage/img/' + response.data.image);
                        $("#editModalStatus").modal("show");
                    }
                    else {
                        $("#status_id").val(response.data.id);
                        $("#content_edit").val(response.data.content);
                        $('#image_edit').attr('src', '{{ URL::asset("/img/default-image.png") }}');
                        $("#editModalStatus").modal("show");
                    }
                },
            });
        });

        //delete
        $("body").on("click", "#btn_delete_status", function () {
            let id = $(this).data("id");
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("farmer.delstatusf", ":id") }}';
            url = url.replace(":id", id);

            Swal.fire({
                title: "Apakah Kamu Yakin?",
                text: "ingin menghapus data ini!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "TIDAK",
                confirmButtonText: "YA, HAPUS!",
            }).then((result) => {
                if (result.isConfirmed) {


                    //fetch to delete data
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        cache: false,
                        data: {
                            _token: token,
                        },
                        success: function (response) {
                            //show success message
                            Swal.fire({
                                type: "success",
                                icon: "success",
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000,
                            });

                            //remove status
                            $(`#index_${id}`).remove();
                        },
                    });
                }
            });

        });
    });


</script>
@endsection