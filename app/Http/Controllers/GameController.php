<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index');
    }
    public function register()
    {

        return view('games.register');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:5',
            'rating' => 'required|numeric|between:0,10',
            'description' => 'nullable',
        ]);

        $newGame = Game::create($data);
        return redirect()->route('games.index');
    }
}
