<?php

namespace App\Http\Controllers\Admin;

use App\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::all();

        return view('adminPanel.genre.index', [
            'genres' => $genres
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.genre.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Genre::create($request->all());

        return redirect()->route('genresPage')
            ->with('success','Жанр успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        return view('adminPanel.genre.show',compact('genre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        return view('adminPanel.genre.edit',compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $genre->update($request->all());

        return redirect()->route('genresPage')
            ->with('success','Жанр успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre $genre
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('genresPage')
            ->with('success','Жанр успешно удален');
    }
}
