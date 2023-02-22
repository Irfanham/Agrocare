@extends('farmer.layouts.app') @section('content')
<div class="card">

    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session("status") }}
        </div>
        @endif

        <div class="mb-3" id="content-feed">

            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <p class="card-text text-justify">{{$post->content}}</p>
                    <p class="card-text">
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </p>
                    <div class="form-group">

                        <a href="{{route('farmer.feedf')}}" class="btn btn-primary float-right">
                            Kembali
                        </a>
                    </div>
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