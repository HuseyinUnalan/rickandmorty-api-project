<?php

namespace App\Http\Controllers;

use App\Models\FavoriteCharacters;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    public function addFavorite(Request $request, $character_id)
    {
        // Kullanıcı oturumunu kontrol et
        if (auth()->check()) {
            $user_id = auth()->user()->id;

            // Karakterin favorilerine eklenip eklenmediğini kontrol et
            $existingFavorite = FavoriteCharacters::where('user_id', $user_id)
                ->where('character_id', $character_id)
                ->exists();

            if (!$existingFavorite) {
                // Favorilere ekleme işlemini gerçekleştir
                $favorite = new FavoriteCharacters();
                $favorite->character_id = $character_id;
                $favorite->user_id = $user_id;
                $favorite->save();

                return response()->json(['message' => 'Character added to favorites successfully'], 200);
            } else {
                return response()->json(['message' => 'Character already exists in favorites'], 400);
            }
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function removeFavorite(Request $request, $character_id)
    {
        // Kullanıcı oturumunu kontrol et
        if (auth()->check()) {
            $user_id = auth()->user()->id;

            // Favorilerden kaldırma işlemini gerçekleştir
            FavoriteCharacters::where('user_id', $user_id)
                ->where('character_id', $character_id)
                ->delete();

            return response()->json(['message' => 'Character removed from favorites successfully'], 200);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function MyFavoriteCharacters()
    {
        // Kullanıcının ID'sini ve favori karakterleri al
        $user_id = auth()->user()->id;
        $myfavoriteCharacters = FavoriteCharacters::where('user_id', $user_id)->get();
    
        $charactersDetails = [];
    
        // Her bir favori karakter için API'yi kullanarak karakter detaylarını çek
        foreach ($myfavoriteCharacters as $character) {
            $character_id = $character->character_id;
            $apiUrl = "https://rickandmortyapi.com/api/character/$character_id";
            $response = file_get_contents($apiUrl);
            $character_details = json_decode($response);
    
            // Karakter detaylarını listeye ekle
            $charactersDetails[] = $character_details;
        }
    
        // Favori karakterleri göstermek için view'a geçir
        return view('favorite.my-favorite-character', compact('myfavoriteCharacters', 'charactersDetails'));
    }
}
