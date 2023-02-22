@extends('expert.layouts.app') @section('content')
<div class="card bg-light mb-3">
    <div class="card-header">Tulis Artikel</div>
    <div class="card-body">
        <form>
            <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}" />
            <div class="form-group">
                <input id="title" type="text" class="form-control" placeholder="Judul Artikel" />
            </div>
            <div class="form-group">
                <textarea id="content" class="form-control" rows="5" placeholder="Isi Artikel"></textarea>
            </div>
            <div class="form-group">
                <!-- <a href="#" role="button" class="ml-1 mr-2">
                    <i class="fa fa-image fa-lg"></i>
                </a>
                <a href="#" role="button" class="mr-2">
                    <i class="fa fa-paperclip fa-lg"></i>
                </a> -->
                <button type="submit" id="submitFeed" class="btn btn-primary float-right">
                    Publish
                </button>
            </div>
        </form>

    </div>
</div>

<div class="mb-3" id="content-feed">
    @foreach($post as $data)
    <div class="card bg-light mb-3" id="index_{{$data->id}}">
        <div class="card-body">
            <h5 class="card-title">{{$data->title}}</h5>
            <p class="card-text text-justify">{{$data->content}}</p>
            <p class="card-text">
                <small class="text-muted">{{ $data->created_at->diffForHumans() }}</small>
            </p>
            <div class="form-group">
                <a href="javascript:void(0)" id="btn_edit_post" data-toggle="modal" data-target="#editModalPost"
                    data-id="{{ $data->id }}" data-toggle="tooltip" title="Edit Artikel" class="mr-1">
                    <i class="fa fa-edit fa-lg"></i>
                </a>
                <a href="javascript:void(0)" id="btn_delete_post" class="mr-1" data-toggle="tooltip"
                    title="Hapus Artikel" data-id="{{$data->id}}">
                    <i class="fa fa-trash fa-lg"></i>
                </a>

                <a href="{{route('expert.reade',$data->id)}}" class="btn btn-primary float-right">
                    Baca
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- Edit Post Modal -->
<div class="modal fade" id="editModalPost" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    Edit Artikel
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postDataEdit">
                @csrf
                <div class="modal-body">
                    <!-- User Data Form Fields -->
                    <div class="form-group">
                        <input type="hidden" id="post_id" name="post_id" value="" />
                        <label for="editTitle">Judul Artikel</label>
                        <input type="text" class="form-control" id="title_edit" />
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="editContent">Isi Artikel</label>
                        <textarea class="form-control" id="content_edit" rows="5"></textarea>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-content-edit"></div>
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
    <div class="card-header text-center">Terbaru</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @foreach($news as $value)
            <a href="#" class="list-group-item nav-link text-justify" style="color:rgba(0, 0, 0, 0.5);">{{
                $value->title}}
                <span style="
                position: absolute;
                left: 0px;
            ">&bull;</span>
                <p class="card-text" style="color:rgba(0, 0, 0, 0.5);">&#64;{{$value->users->username}}</p>
            </a>

            @endforeach
        </div>
    </div>
</div>
<div class="card bg-light mb-3">
    <div class="card-header text-center">Konsultan</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @foreach($consult as $ta)
            <a href="#" class="list-group-item nav-link" style="color:rgba(0, 0, 0, 0.5);">{{$ta->name}}
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

        $('#submitFeed').on('click', (function (e) {
            e.preventDefault();
            var user_id = $('#user_id').val();
            var title = $('#title').val();
            var content = $('#content').val();
            let url = '{{route("expert.addposte")}}';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    user_id: user_id,
                    title: title,
                    content: content
                },
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

                    //data post
                    var id = `${response.data.id}`;
                    var url = '{{route("expert.reade", ":id")}}';
                    url = url.replace(":id", id);
                    let post = `
                    <div class="card bg-light mb-3" id="index_${response.data.id}">
                    <div class="card-body">
                                <h5 class="card-title">${response.data.title}</h5>
                                <p class="card-text text-justify">${response.data.content}</p>
                                <p class="card-text">

                                    <small class="text-muted">${response.date}</small>
                                </p>
                                <div class="form-group">
                                    <a href="javascript:void(0)" id="btn_edit_post" data-toggle="modal" data-target="#editModal"
                                        data-id="${response.data.id}" data-toggle="tooltip" title="Edit Post" class="mr-1">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="btn_delete_post" class="mr-1" data-toggle="tooltip" title="Hapus Post"
                                        data-id="${response.data.id}">
                                        <i class="fa fa-trash fa-lg"></i>
                                    </a>

                                    <a href="${url}"  class="btn btn-primary float-right">
                                        Baca
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#content-feed').prepend(post);

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
        $("body").on("click", "#submit", function (event) {
            event.preventDefault();
            var id = $("#post_id").val();
            var title = $("#title_edit").val();
            var content = $("#content_edit").val();
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("expert.updateposte", ":id") }}';
            url = url.replace(":id", id);


            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: {
                    id: id,
                    title: title,
                    content: username,
                    _token: token,
                },
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
                    let post = `
                       <div class="card bg-light mb-3" id="index_${response.data.id}">
                        <div class="card-body">
                                    <h5 class="card-title">${response.data.title}</h5>
                                    <p class="card-text text-justify">${response.data.content}</p>
                                    <p class="card-text">

                                        <small class="text-muted">${response.date}</small>
                                    </p>
                                    <div class="form-group">
                                        <a href="javascript:void(0)" id="btn_edit_post" data-toggle="modal" data-target="#editModal"
                                            data-id="${response.data.id}" data-toggle="tooltip" title="Edit Post" class="mr-1">
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="btn_delete_post" class="mr-1" data-toggle="tooltip" title="Hapus Post"
                                            data-id="${response.data.id}">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </a>

                                        <a href="${url}"  class="btn btn-primary float-right">
                                            Baca
                                        </a>
                                    </div>
                                </div>
                            </div>
                    `;

                    //append to post data
                    $(`#index_${response.data.id}`).replaceWith(post);

                    //modal hide
                    $("#editModal").modal("hide");
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
        $("body").on("click", "#btn_edit_post", function (event) {
            let id = $(this).data("id");
            var url = '{{ route("expert.showposte", ":id") }}';
            url = url.replace(":id", id);

            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                dataType: "json",
                success: function (response) {
                    $("#post_id").val(response.data.id);
                    $("#title_edit").val(response.data.title);
                    $("#content_edit").val(response.data.content);
                    $("#editModal").modal("show");
                },
            });
        });

        //delete
        $("body").on("click", "#btn_delete_post", function () {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("expert.delposte", ":id") }}';
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

                            //remove post
                            $(`#index_${id}`).remove();
                        },
                    });
                }
            });

        });
    });


</script>
@endsection