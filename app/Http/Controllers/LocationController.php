<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function Locations(Request $request)
    {

        $locationsApiUrl = "https://rickandmortyapi.com/api/location";

        if ($request->has('page')) {
            $locationsApiUrl .= '?page=' . $request->input('page');
        }

        $locationsResponse = file_get_contents($locationsApiUrl);
        $locationsData = json_decode($locationsResponse);
        $locations = $locationsData->results;

        $totalPages = $locationsData->info->pages;
        $nextPageUrl = $locationsData->info->next;

        $currentPage = request()->input('page', 1);
        $start = max($currentPage - 2, 1);
        $end = min($currentPage + 2, $totalPages);

        return view('locations.locations', compact('locations', 'totalPages', 'nextPageUrl', 'currentPage', 'start', 'end'));
    }

    public function LocationShow($id)
    {
        // API'den lokasyon detaylarını çekme
        $apiUrl = "https://rickandmortyapi.com/api/location/$id";
        $response = file_get_contents($apiUrl);
        $locationdetail = json_decode($response);
    
        // Lokasyona ait karakterlerin API URL'lerini al
        $locationscharacters = $locationdetail->residents;
    
        // Lokasyona ait karakter detaylarını saklamak için bir dizi oluştur
        $characterDetails = [];
    
        // Her bir karakter için API'den detayları çekerek diziye ekle
        foreach ($locationscharacters as $characterUrl) {
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
    
        return view('locations.location_detail', compact('locationdetail', 'characterDetails'));
    }
}
