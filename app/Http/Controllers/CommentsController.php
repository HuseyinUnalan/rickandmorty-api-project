<?php

namespace App\Http\Controllers;

use App\Models\CharacterComments;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function AddComment(Request $request, $character_id)
    {

        $user_id = auth()->user()->id;
        CharacterComments::insert([

            'user_id' => $user_id,
            'character_id' => $character_id,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back();
    }
}
