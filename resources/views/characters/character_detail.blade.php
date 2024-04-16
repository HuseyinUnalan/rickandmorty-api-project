@extends('main_master')
@section('content')
@section('title')
    {{ $charterdetail->name }} - Character Details
@endsection


<div class="container mt-5">
    <div class="row">

        <div class="col-md-3">
            <img src="{{ $charterdetail->image }}" class="img-fluid" alt="">
        </div>

        <div class="col-md-5">
            <h1>{{ $charterdetail->name }}</h1>
            <p><b> Status: </b> {{ $charterdetail->status }}</p>
            <p><b> Species: </b> {{ $charterdetail->species }}</p>
            <p><b> Gender: </b> {{ $charterdetail->gender }}</p>
            <p> <b>Location: </b> <a href="{{ url('location', $lastSegment) }}"
                    class="link">{{ $charterdetail->location->name }} </a>
            </p>
            @auth
                @php
                    $user_id = auth()->user()->id;
                    $character_id = $charterdetail->id;
                    // Karakterin favorilerine eklenip eklenmediğini kontrol et
                    $existingFavorite = App\Models\FavoriteCharacters::where('user_id', $user_id)
                        ->where('character_id', $character_id)
                        ->exists();
                @endphp

                @if (!$existingFavorite)
                    <button onclick="manageFavorite({{ $charterdetail->id }})" id="favoriteButton_{{ $charterdetail->id }}"
                        class="btn btn-color">
                        Add Favorite
                    </button>
                @else
                    <button onclick="manageFavorite({{ $charterdetail->id }})"
                        id="favoriteButton_{{ $charterdetail->id }}" class="btn btn-danger">
                        Remove Favorite
                    </button>
                @endif
            @else
            @endauth

        </div>

        <div class="col-md-4">

            <p> <b>Episodes it appears in</b> </p>
            <ul class="list-group">
                @foreach ($episodeDetails as $episode)
                    <li class="list-group-item link"><a
                            href="{{ url('episode', $episode->id) }}">{{ $episode->name }}</a>
                    </li>
                @endforeach
            </ul>


        </div>

        <div>
            <section style="background-color: #eee;">
                <div class="container my-5 py-5">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 col-lg-10 col-xl-8">
                            <div class="card">

                                @foreach ($chartercomments as $comment)
                                    <div class="card-body">
                                        <div class="d-flex flex-start align-items-center">
                                            <div class="avatar" style="margin-right: 7px">
                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-primary mb-1">{{ $comment->user->name }}</h6>
                                                <p class="text-muted small mb-0">
                                                    {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-4 pb-2">
                                            {{ $comment->description }}
                                        </p>
                                    </div>
                                @endforeach


                                @auth
                                    <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">

                                        <form action="{{ route('add.comment', $charterdetail->id) }}" method="POST">
                                            @csrf
                                            <div class="d-flex flex-start w-100">
                                                <div class="avatar" style="margin-right: 7px">
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                </div>
                                                <div class="form-outline w-100">
                                                    <label class="form-label" for="textAreaExample">Message</label>
                                                    <textarea class="form-control" id="textAreaExample" name="description" rows="4" style="background: #fff;"></textarea>
                                                </div>
                                            </div>
                                            <div class="float-end mt-2 pt-1">
                                                <button type="submit" class="btn btn-primary btn-sm">Post comment</button>
                                            </div>
                                        </form>


                                    </div>
                                @else
                                @endauth

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
</div>

@endsection
