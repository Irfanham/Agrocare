@extends('farmer.layouts.app') @section('content')


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

                <a href="{{route('farmer.readf',$data->id)}}" class="btn btn-primary float-right">
                    Baca
                </a>
            </div>
        </div>
    </div>
    @endforeach
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




    });


</script>
@endsection