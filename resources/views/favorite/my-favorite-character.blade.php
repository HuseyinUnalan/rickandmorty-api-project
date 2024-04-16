@extends('main_master')
@section('content')
@section('title')
    My Favorite Characters
@endsection

<div class="container mt-3">
    <div class="row">
        @foreach ($charactersDetails as $character)
            <div class="card mb-3 col-md-3">
                <img class="card-img-top" src="{{ $character->image }}" alt="Card image" style="width:100%">
                <div class="card-body">
                    <h4 class="card-title">{{ $character->name }}</h4>
                    <p class="card-text"><b>Status: </b>
                        @if ($character->status === 'Dead')
                            <span class="badge bg-danger"> {{ $character->status }}</span>
                        @elseif ($character->status === 'Alive')
                            <span class="badge bg-success"> {{ $character->status }}</span>
                        @else
                            <span class="badge bg-warning"> {{ $character->status }}</span>
                        @endif
                    </p>
                    <p class="card-text"><b>Species: </b> {{ $character->species }} </p>
                    <a href="{{ url('character', $character->id) }}" class="btn btn-color">See Character</a>

                    @php
                        $user_id = auth()->user()->id;
                        $character_id = $character->id;
                        // Karakterin favorilerine eklenip eklenmediğini kontrol et
                        $existingFavorite = App\Models\FavoriteCharacters::where('user_id', $user_id)
                            ->where('character_id', $character_id)
                            ->exists();
                    @endphp

                    @if (!$existingFavorite)
                        <button onclick="manageFavorite({{ $character->id }})" id="favoriteButton_{{ $character->id }}"
                            class="btn btn-color">
                            Add Favorite
                        </button>
                    @else
                        <button onclick="manageFavorite({{ $character->id }})" id="favoriteButton_{{ $character->id }}"
                            class="btn btn-danger">
                            Remove Favorite
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>







@endsection
