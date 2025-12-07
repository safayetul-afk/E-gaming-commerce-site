<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        dd($request);
    }
}
