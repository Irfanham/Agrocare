@extends('admin.layouts.app') @section('content')
<div class="card">
    <div class="card-header">{{ __("Update Profile") }}</div>

    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session("status") }}
        </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.updateProfile') }}"
            enctype="multipart/form-data"
        >
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    aria-describedby="nameHelp"
                    value="{{$user->name}}"
                />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    aria-describedby="emailHelp"
                    value="{{$user->email}}"
                />
            </div>
            <div class="form-group">
                <label for="nohp">No Hp</label>

                <input
                    type="text"
                    class="form-control"
                    name="nohp"
                    aria-describedby="nohpHelp"
                    value="{{$user->nohp}}"
                />
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input
                    type="text"
                    class="form-control"
                    name="alamat"
                    aria-describedby="alamatHelp"
                    value="{{$user->alamat}}"
                />
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    class="form-control"
                    name="username"
                    aria-describedby="alamatHelp"
                    value="{{$user->username}}"
                />
            </div>

            <div class="form-group">
                <label for="image">Profile Image</label>
                <input
                    id="images"
                    type="file"
                    name="image"
                    class="form-control-file"
                />
            </div>
            <button type="submit" class="btn btn-primary">
                Update Profile
            </button>
        </form>
    </div>
</div>
@endsection
