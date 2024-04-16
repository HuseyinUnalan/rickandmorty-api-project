<?php

namespace App\Http\Controllers;

use App\Models\CharacterComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CharacterController extends Controller
{
    public function Characters(Request $request)
    {

        // Karakterleri çekme
        $characterApiUrl = "https://rickandmortyapi.com/api/character";

        // Eğer sayfa numarası belirtilmişse, URL'yi güncelle
        if ($request->has('page')) {
            $characterApiUrl .= '?page=' . $request->input('page');
        }


        $characterResponse = file_get_contents($characterApiUrl);
        $characterData = json_decode($characterResponse);
        $characters = $characterData->results;

        // API'den gelen sayfalama bilgileri
        $totalPages = $characterData->info->pages;
        $nextPageUrl = $characterData->info->next;

        $currentPage = request()->input('page', 1);
        $start = max($currentPage - 2, 1);
        $end = min($currentPage + 2, $totalPages);

        return view('characters.characters', compact('characters', 'totalPages', 'nextPageUrl', 'currentPage', 'start', 'end'));
    }

    public function CharacterShow($id)
    {

        $apiUrl = "https://rickandmortyapi.com/api/character/$id";
        $response = file_get_contents($apiUrl);
        $charterdetail = json_decode($response);

        $charterepisodes = $charterdetail->episode;



        $episodeDetails = [];
        foreach ($charterepisodes as $episodeUrl) {

            $cacheKey = 'episode_' . md5($episodeUrl);

            $episodeDetail = Cache::remember($cacheKey, now()->addHours(1), function () use ($episodeUrl) {
                $episodeResponse = file_get_contents($episodeUrl);
                return json_decode($episodeResponse);
            });
            $episodeDetails[] = $episodeDetail;
        }

        $url = $charterdetail->location->url;

        // URL'yi parçala
        $urlParts = parse_url($url);

        // Yolu parçala ve son kısmı al
        $lastSegment = basename($urlParts['path']);

        $chartercomments = CharacterComments::where('character_id', $id)->get();

        return view('characters.character_detail', compact('charterdetail', 'episodeDetails', 'lastSegment', 'chartercomments'));
    }
}
