<?php

namespace App\Http\Controllers;

use App\Models\FavoriteCharacters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function Index(Request $request)
    {
        // Karakterleri toplamak için boş bir dizi oluştur
        $allCharacters = Cache::remember('all_characters', now()->addHours(1), function () {
            // API'den tüm sayfaları dolaşarak karakterleri topla
            $allCharacters = [];

            $characterApiUrl = "https://rickandmortyapi.com/api/character";
            $nextPageUrl = $characterApiUrl;

            while ($nextPageUrl) {
                $characterResponse = file_get_contents($nextPageUrl);
                $characterData = json_decode($characterResponse);

                // Karakterleri diziye ekle
                $allCharacters = array_merge($allCharacters, $characterData->results);

                // Bir sonraki sayfa varsa, bir sonraki sayfa URL'sini al
                $nextPageUrl = $characterData->info->next;
            }

            return $allCharacters;
        });

        // Tüm karakterlerin sayısını al
        $totalCharacters = count($allCharacters);

        // Rastgele 5 karakter seç
        $randomIndexes = array_rand($allCharacters, min(4, $totalCharacters));
        $randomCharacters = [];
        foreach ($randomIndexes as $index) {
            $randomCharacters[] = $allCharacters[$index];
        }

        // Bölümleri çekme
        $episodeApiUrl = "https://rickandmortyapi.com/api/episode";
        $episodes = Cache::remember('episodes', now()->addHours(1), function () use ($episodeApiUrl) {
            $episodeResponse = file_get_contents($episodeApiUrl);
            return json_decode($episodeResponse)->results;
        });
        

        return view('index', compact('episodes', 'randomCharacters', 'totalCharacters'));
    }

    public function checkFavoriteStatus($userId, $characterId)
    {
        // Karakterin favorilere eklenip eklenmediğini kontrol et
        $existingFavorite = FavoriteCharacters::where('user_id', $userId)
            ->where('character_id', $characterId)
            ->exists();

        return $existingFavorite;
    }

    public function Search(Request $request)
    {
        // Tüm karakterleri önbellekten al
        $allCharacters = Cache::remember('all_characters', now()->addHours(1), function () {
            // API'den tüm sayfaları dolaşarak karakterleri topla
            $allCharacters = [];

            $characterApiUrl = "https://rickandmortyapi.com/api/character";
            $nextPageUrl = $characterApiUrl;

            while ($nextPageUrl) {
                $characterResponse = file_get_contents($nextPageUrl);
                $characterData = json_decode($characterResponse);

                // Karakterleri diziye ekle
                $allCharacters = array_merge($allCharacters, $characterData->results);

                // Bir sonraki sayfa varsa, bir sonraki sayfa URL'sini al
                $nextPageUrl = $characterData->info->next;
            }

            return $allCharacters;
        });

        // Arama terimini al
        $searchTerm = $request->input('searchkeyword');

        // Karakterler arasında arama yap
        $searchResults = array_filter($allCharacters, function ($character) use ($searchTerm) {
            return stripos($character->name, $searchTerm) !== false;
        });

       

        return view('search', compact('searchResults'));
    }

    public function Logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
