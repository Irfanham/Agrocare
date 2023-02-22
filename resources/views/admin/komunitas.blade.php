@extends('admin.layouts.app') @section('content')
<div class="card bg-light mb-3">
    <div class="card-body">
        <form>
            <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}" />

            <div class="form-group">
                <textarea id="content" class="form-control" rows="5" placeholder="Apa yang Anda pikirkan ?"></textarea>
            </div>
            <div class="form-group">
                <a href="#" role="button" class="ml-1 mr-2">
                    <i class="fa fa-image fa-lg"></i>
                </a>
                <a href="#" role="button" class="mr-2">
                    <i class="fa fa-paperclip fa-lg"></i>
                </a>
                <button type="submit" id="submitFeed" class="btn btn-primary float-right">
                    Publish
                </button>
            </div>
        </form>

    </div>
</div>

<div class="mb-3" id="content-feed">
    @foreach($status as $data)
    <div class="card bg-light mb-3" id="index_{{$data->id}}">
        <div class="card-body">
            <p class="card-text text-justify">{{$data->content}}</p>
            <p class="card-text">
                <small class="text-muted">{{ $data->created_at->diffForHumans() }}</small>
            </p>

            <div class="form-group ">
                <a href="javascript:void(0)" id="like-button" class="mr-1">
                    <i class="fa fa-heart fa-lg fa-lk">
                    </i>
                </a>
                <a href="javascript:void(0)" class="mr-1">
                    <i class="fa fa-comment fa-lg fa-cl fa-m"></i>
                </a>
                <a href="javascript:void(0)" id="btn_delete_status" class="float-right mr-1" data-toggle="tooltip"
                    title="Hapus Status" data-id="{{$data->id}}">
                    <i class="fa fa-trash fa-lg"></i>
                </a>
                <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                    data-id="{{ $data->id }}" data-toggle="tooltip" title="Edit Status" class="float-right mr-1">
                    <i class="fa fa-edit fa-lg"></i>
                </a>
            </div>
        </div>
    </div>
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
    <div class="card-header text-center">Teman</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @foreach($friend as $value)
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
            var content = $('#content').val();
            let url = '{{route("admin.addStatus")}}';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    user_id: user_id,
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

                    //data status
                    var id = `${response.data.id}`;
                    let status = `
                    <div class="card bg-light mb-3" id="index_${response.data.id}">
                    <div class="card-body">
                                <p class="card-text text-justify">${response.data.content}</p>
                                <p class="card-text">

                                    <small class="text-muted">${response.date}</small>
                                </p>
                                <div class="form-group ">
                                    <a href="javascript:void(0)" id="like-button" class="mr-1">
                                        <i class="fa fa-heart fa-lg fa-lk">
                                        </i>
                                    </a>
                                    <a href="javascript:void(0)" class="mr-1">
                                        <i class="fa fa-comment fa-lg fa-cl fa-m"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="btn_delete_status" class="float-right mr-1" data-toggle="tooltip"
                                        title="Hapus Status" data-id="${response.data.id}">
                                        <i class="fa fa-trash fa-lg"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                                        data-id="${response.data.id}" data-toggle="tooltip" title="Edit Status" class="float-right mr-1">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;

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
        $("body").on("click", "#submit", function (event) {
            event.preventDefault();
            var id = $("#status_id").val();
            var title = $("#title_edit").val();
            var content = $("#content_edit").val();
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("admin.updateStatus", ":id") }}';
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
                    let status = `
                       <div class="card bg-light mb-3" id="index_${response.data.id}">
                        <div class="card-body">
                                    <h5 class="card-title">${response.data.title}</h5>
                                    <p class="card-text text-justify">${response.data.content}</p>
                                    <p class="card-text">

                                        <small class="text-muted">${response.date}</small>
                                    </p>
                                    <div class="form-group ">
                                        <a href="javascript:void(0)" id="like-button" class="mr-1">
                                            <i class="fa fa-heart fa-lg fa-lk">
                                            </i>
                                        </a>
                                        <a href="javascript:void(0)" class="mr-1">
                                            <i class="fa fa-comment fa-lg fa-cl fa-m"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="btn_delete_status" class="float-right mr-1" data-toggle="tooltip"
                                            title="Hapus Status" data-id="${response.data.id}">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="btn_edit_status" data-toggle="modal" data-target="#editModalStatus"
                                            data-id="${response.data.id}" data-toggle="tooltip" title="Edit Status" class="float-right mr-1">
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    `;

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
            var url = '{{ route("admin.showStatus", ":id") }}';
            url = url.replace(":id", id);

            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                dataType: "json",
                success: function (response) {
                    $("#status_id").val(response.data.id);
                    $("#content_edit").val(response.data.content);
                    $("#editModalStatus").modal("show");
                },
            });
        });

        //delete
        $("body").on("click", "#btn_delete_status", function () {
            let id = $(this).data("id");
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("admin.delStatus", ":id") }}';
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

        $(".fa-lk").click(function () {
            $(this).toggleClass("fa-ac");
        });

    });


</script>
@endsection