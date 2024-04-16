<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [IndexController::class, 'Index'])->name('/');
Route::post('/search', [IndexController::class, 'Search'])->name('search');
Route::get('logout', [IndexController::class, 'Logout'])->name('logout');


Route::get('/characters', [CharacterController::class, 'Characters'])->name('characters');
Route::get('character/{id}', [CharacterController::class, 'CharacterShow'])->name('character/show');


Route::get('/episodes', [EpisodesController::class, 'Episodes'])->name('episodes');
Route::get('episode/{id}', [EpisodesController::class, 'EpisodeShow'])->name('episode/show');

Route::get('locations', [LocationController::class, 'Locations'])->name('locations');
Route::get('location/{id}', [LocationController::class, 'LocationShow'])->name('location/show');

Route::middleware('auth')->group(function () {
    Route::post('/favorite/add/{character_id}', [FavoriteController::class, 'AddFavorite'])->name('favorite.add');
    Route::post('/favorite/remove/{character_id}', [FavoriteController::class, 'removeFavorite'])->name('favorite.remove');
    Route::get('/my/favorite/characters', [FavoriteController::class, 'MyFavoriteCharacters'])->name('my.favorite.characters');

    Route::post('/add/comment/{character_id}', [CommentsController::class, 'AddComment'])->name('add.comment');

});





Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
