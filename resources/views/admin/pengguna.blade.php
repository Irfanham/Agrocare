@extends('admin.layouts.app') @section('content')
<div class="card">
    <div class="card-header">{{ __("Data Pengguna") }}</div>

    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session("status") }}
        </div>
        @endif
        <a href="javascript:void(0)" class="btn btn-success mb-2 float-right" id="btn_create_user" data-toggle="modal"
            data-target="#addModal">TAMBAH</a>
        <table class="table table-responsive-sm table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th>Pekerjaan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="table-user">
                <!-- User Data Rows -->
                @foreach($user as $data)
                <tr id="index_{{$data->id}}">
                    <td>{{$data->name}}</td>
                    <td>{{$data->username}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->nohp}}</td>
                    <td>{{$data->alamat}}</td>
                    <td>{{$data->roles->role_name}}</td>
                    <td>
                        <input id="toggle-event" type="checkbox" data-id="{{$data->id}}" class="toggle-class"
                            data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Aktif"
                            data-off="Blokir" data-size="xs" {{ $data->status_ban == true ? 'checked' : '' }} >

                    </td>
                    <td>
                        <a href="javascript:void(0)" id="btn_edit_user" data-toggle="modal" data-target="#editModal"
                            data-id="{{ $data->id }}" data-toggle="tooltip" title="Edit User"
                            class="btn btn-primary btn-sm edit"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" id="btn_delete_user" class="btn btn-danger btn-sm"
                            data-toggle="tooltip" title="Hapus User" data-id="{{$data->id}}"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Add User Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">
                            Tambah User
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="userData">
                        @csrf

                        <div class="modal-body">
                            <!-- User Data Form Fields -->
                            <div class="form-group">
                                <label for="addName">Nama</label>
                                <input type="text" class="form-control" id="add_name" />
                            </div>
                            <div class="form-group">
                                <label for="addUname">Username</label>
                                <input type="text" class="form-control" id="add_uname" />
                            </div>
                            <div class="form-group">
                                <label for="addEmail">Email</label>
                                <input type="email" class="form-control" id="add_email" />
                            </div>
                            <div class="form-group">
                                <label for="addPassword">Password</label>
                                <input type="password" class="form-control" id="add_password" />
                            </div>
                            <div class="form-group">
                                <label for="addNohp">No Hp</label>
                                <input type="text" class="form-control" id="add_nohp" />
                            </div>
                            <div class="form-group">
                                <label for="addAlamat">Alamat</label>
                                <input type="text" class="form-control" id="add_alamat" />
                            </div>
                            <div class="form-group">
                                <label for="addRole">Pekerjaan</label>
                                <select id="add_role" class="form-control">
                                    @foreach($user as $data)
                                    <option value="{{ $data->role_id }}">
                                        {{ $data->roles->role_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Keluar
                            </button>
                            <button type="submit" id="add_submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">
                            Edit User
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="userDataEdit">
                        @csrf

                        <div class="modal-body">
                            <!-- User Data Form Fields -->
                            <div class="form-group">
                                <input type="hidden" id="user_id" name="user_id" value="" />
                                <label for="editName">Nama</label>
                                <input type="text" class="form-control" id="edit_name" />
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name-edit"></div>
                            </div>
                            <div class="form-group">
                                <label for="editUname">Username</label>
                                <input type="text" class="form-control" id="edit_uname" />
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-uname-edit"></div>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input type="email" class="form-control" id="edit_email" />
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email-edit"></div>
                            </div>
                            <div class="form-group">
                                <label for="editNohp">No Hp</label>
                                <input type="text" class="form-control" id="edit_nohp" />
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nohp-edit"></div>
                            </div>
                            <div class="form-group">
                                <label for="editAlamat">Alamat</label>
                                <input type="text" class="form-control" id="edit_alamat" />
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat-edit"></div>
                            </div>
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

        //status
        $('.toggle').click(function () {
            var status_ban = $(this).children().prop('checked') == true ? 0 : 1;
            var id = $(this).children().data('id');
            var url = '{{ route("admin.changeUser") }}';


            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                data: { id: id, status_ban: status_ban, },
                success: function (data) {
                    console.log(data.success)
                }
            });

        });


        //create
        $("body").on("click", "#btn_create_user", function (event) {
            $("#addModal").modal("show");
        });

        //action create user
        $("#add_submit").click(function (event) {
            event.preventDefault();

            //define variable
            let name = $("#add_name").val();
            let username = $("#add_username").val();
            let email = $("#add_email").val();
            let password = $("#add_password").val();
            let nohp = $("#add_nohp").val();
            let alamat = $("#add_alamat").val();
            let role = $("#add_role").val();
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("admin.addUser") }}';

            //ajax
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: {
                    name: name,
                    username: username,
                    email: email,
                    password: password,
                    nohp: nohp,
                    alamat: alamat,
                    role: role,
                    _token: token,
                },
                success: function (response) {
                    //show success message
                    Swal.fire({
                        type: "success",
                        icon: "success",
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    //data user
                    let user = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.name}</td>
                        <td>${response.data.username}</td>
                        <td>${response.data.email}</td>
                        <td>${response.data.nohp}</td>
                        <td>${response.data.alamat}</td>
                        <td>${response.data.roles.role_name}</td>
                        <td>${response.data.status_ban}</td>
                        <td>
                            <a
                            href="javascript:void(0)"
                            id="btn_edit_user"
                            data-toggle="modal"
                            data-target="#editModal"
                            data-id="${response.data.id}"
                            data-toggle="tooltip"
                            title="Edit User"
                            class="btn btn-primary btn-sm edit"
                            ><i class="fa fa-edit"></i
                        ></a>
                        <a
                            href="javascript:void(0)"
                            id="btn_delete_user"
                            class="btn btn-danger btn-sm"
                            data-toggle="tooltip"
                            title="Hapus User"
                            data-id="${response.data.id}"
                            ><i class="fa fa-trash"></i
                        ></a>
                        </td>
                    </tr>
                `;

                    //append to table
                    $("#table-user").prepend(user);

                    //clear form
                    $("#add_name").val("");
                    $("#add_username").val("");
                    $("#add_email").val("");
                    $("#add_password").val("");
                    $("#add_nohp").val("");
                    $("#add_alamat").val("");

                    //close modal
                    $("#modal-create").modal("hide");
                },
            });
        });

        //update
        $("body").on("click", "#submit", function (event) {
            event.preventDefault();
            var id = $("#user_id").val();
            var name = $("#edit_name").val();
            var username = $("#edit_uname").val();
            var email = $("#edit_email").val();
            var nohp = $("#edit_nohp").val();
            var alamat = $("#edit_alamat").val();
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("admin.editUser", ":id") }}';
            url = url.replace(":id", id);

            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: {
                    id: id,
                    name: name,
                    username: username,
                    email: email,
                    nohp: nohp,
                    alamat: alamat,
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
                    let user = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.name}</td>
                        <td>${response.data.username}</td>
                        <td>${response.data.email}</td>
                        <td>${response.data.nohp}</td>
                        <td>${response.data.alamat}</td>
                        <td>${response.data.roles.role_name}</td>
                        <td>${response.data.status_ban}</td>
                        <td>
                            <a
                            href="javascript:void(0)"
                            id="btn_edit_user"
                            data-toggle="modal"
                            data-target="#editModal"
                            data-id="${response.data.id}"
                            data-toggle="tooltip"
                            title="Edit User"
                            class="btn btn-primary btn-sm edit"
                            ><i class="fa fa-edit"></i
                        ></a>
                        <a
                            href="javascript:void(0)"
                            id="btn_delete_user"
                            class="btn btn-danger btn-sm"
                            data-toggle="tooltip"
                            title="Hapus User"
                            data-id="${response.data.id}"
                            ><i class="fa fa-trash"></i
                        ></a>
                        </td>
                    </tr>
                `;

                    //append to post data
                    $(`#index_${response.data.id}`).replaceWith(user);

                    //modal hide
                    $("#editModal").modal("hide");
                },

                error: function (error) {
                    if (error.responseJSON.name[0]) {
                        //show alert
                        $("#alert-name-edit").removeClass("d-none");
                        $("#alert-name-edit").addClass("d-block");

                        //add message to alert
                        $("#alert-name-edit").html(error.responseJSON.name[0]);
                    }

                    if (error.responseJSON.username[0]) {
                        //show alert
                        $("#alert-uname-edit").removeClass("d-none");
                        $("#alert-uname-edit").addClass("d-block");

                        //add message to alert
                        $("#alert-uname-edit").html(
                            error.responseJSON.username[0]
                        );
                    }
                    if (error.responseJSON.email[0]) {
                        //show alert
                        $("#alert-email-edit").removeClass("d-none");
                        $("#alert-email-edit").addClass("d-block");

                        //add message to alert
                        $("#alert-email-edit").html(
                            error.responseJSON.email[0]
                        );
                    }
                    if (error.responseJSON.nohp[0]) {
                        //show alert
                        $("#alert-nohp-edit").removeClass("d-none");
                        $("#alert-nohp-edit").addClass("d-block");

                        //add message to alert
                        $("#alert-nohp-edit").html(error.responseJSON.nohp[0]);
                    }
                    if (error.responseJSON.alamat[0]) {
                        //show alert
                        $("#alert-alamat-edit").removeClass("d-none");
                        $("#alert-alamat-edit").addClass("d-block");

                        //add message to alert
                        $("#alert-alamat-edit").html(
                            error.responseJSON.alamat[0]
                        );
                    }
                },
            });
        });

        //show edit
        $("body").on("click", "#btn_edit_user", function (event) {
            let id = $(this).data("id");

            var url = '{{ route("admin.showUser", ":id") }}';
            url = url.replace(":id", id);

            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                dataType: "json",
                success: function (response) {

                    $("#user_id").val(response.data.id);
                    $("#edit_name").val(response.data.name);
                    $("#edit_uname").val(response.data.username);
                    $("#edit_email").val(response.data.email);
                    $("#edit_nohp").val(response.data.nohp);
                    $("#edit_alamat").val(response.data.alamat);
                    $("#editModal").modal("show");
                },
            });
        });

        //delete
        $("body").on("click", "#btn_delete_user", function () {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route("admin.delUser", ":id") }}';
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

                            //remove post on table
                            $(`#index_${id}`).remove();
                        },
                    });
                }
            });
        });
    });



</script>
@endsection