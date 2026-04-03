<?php

namespace App\Http\Controllers;

use App\Models\Movie;

use Illuminate\Http\Request;

class MovieController extends Controller
{

    public function index()
    {
        $movies = Movie::all();

        return response()->json([
            'movies' => $movies
        ]);
    }


    public function store(Request $request)
    {

      $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $posterPath = $request->file('poster')->store('posters', 'public');

        $movie = Movie::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'poster' => $posterPath,
        ]);

        return response()->json([
            'message' => 'Movie created successfully',
            'movie' => $movie
        ], 201);


    }
}
