<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function show($id)
    {

        $activeStory = $id;

        return view('stories', [
            'activeStory' => $activeStory,
        ]);
    }
}
