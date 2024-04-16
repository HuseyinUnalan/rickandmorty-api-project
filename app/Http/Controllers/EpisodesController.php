<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EpisodesController extends Controller
{
    public function Episodes(Request $request)
    {

        // Bölüm çekme
        $episodeApiUrl = "https://rickandmortyapi.com/api/episode";

        // Eğer sayfa numarası belirtilmişse, URL'yi güncelle
        if ($request->has('page')) {
            $episodeApiUrl .= '?page=' . $request->input('page');
        }

        $episodeResponse = file_get_contents($episodeApiUrl);
        $episodeData = json_decode($episodeResponse);
        $episodes = $episodeData->results;

        $totalPages = $episodeData->info->pages;
        $nextPageUrl = $episodeData->info->next;

        $currentPage = request()->input('page', 1);
        $start = max($currentPage - 2, 1);
        $end = min($currentPage + 2, $totalPages);

        return view('episodes.episodes', compact('episodes', 'totalPages', 'nextPageUrl', 'currentPage', 'start', 'end'));
    }

    public function EpisodeShow($id)
    {
        $apiUrl = "https://rickandmortyapi.com/api/episode/$id";
        $response = file_get_contents($apiUrl);
        $episodedetail = json_decode($response);

        $episodescharacters = $episodedetail->characters;

        // Lokasyona ait karakter detaylarını saklamak için bir dizi oluştur
        $characterDetails = [];

        // Her bir karakter için API'den detayları çekerek diziye ekle
        foreach ($episodescharacters as $characterUrl) {
            // Önbellekleme anahtarı oluştur
            $cacheKey = 'character_' . md5($characterUrl);

            // Önbelleğe alınmış veriyi kontrol et
            $characterDetail = Cache::remember($cacheKey, now()->addHours(1), function () use ($characterUrl) {
                // Önbellekte veri yoksa API'den çek
                $characterResponse = file_get_contents($characterUrl);
                return json_decode($characterResponse);
            });

            // Karakter detaylarını diziye ekle
            $characterDetails[] = $characterDetail;
        }


        return view('episodes.episode_detail', compact('episodedetail', 'characterDetails'));
    }
}
