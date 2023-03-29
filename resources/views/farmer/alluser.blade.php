@extends('farmer.layouts.app') @section('content')
<div class="card">
    <div class="card-header">{{ __("Semua Pengguna") }}</div>

    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session("status") }}
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="list-group">
                    @foreach($alluser as $value)
                    <div id="index_{{$value->id}}" class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div>
                                    <a href="{{ route('farmer.profileuser',$value->id) }}">
                                        <img class="rounded-circle mr-3 " style="width: 100%;
                                    height: 50px;
                                    max-width: 50px;" src="{{
                                        asset('storage/img/'.$value->photo_profile)
                                    }}" alt="profile_picture" />
                                    </a>
                                </div>
                                <a href="{{ route('farmer.profileuser',$value->id) }}">
                                    <h5 class="mb-0">{{$value->name}}</h5>
                                </a>
                            </div>
                            @if($value->id==Auth::user()->id)
                            <input type="hidden" />
                            @elseif(Auth::user()->isFollowing($value->id))
                            <form action="{{route('farmer.unfollow', ['id' => $value->id])}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" id="delete-follow-{{ $value->id }}" class="btn btn-danger">
                                    <i class="fa fa-btn fa-check"></i>&ensp;Teman
                                </button>
                            </form>
                            @else
                            <form action="{{route('farmer.follow', ['id' => $value->id])}}" method="POST">
                                {{ csrf_field() }}

                                <button type="submit" id="follow-user-{{ $value->id }}" class="btn btn-success">
                                    <i class="fa fa-btn fa-plus"></i>&ensp;Tambah Teman
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>


    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        //addfriend

        $('#btn-add-friend').click(function (event) {

        });



    });
</script>
@endsection