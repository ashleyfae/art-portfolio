<?php

namespace App\Http\Controllers;

use App\Actions\Artwork\ListArtwork;
use App\DataTransferObjects\FilterArtwork;
use App\Http\Requests\FilterArtworkRequest;
use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Artwork;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterArtworkRequest $request, ListArtwork $listArtwork)
    {
        $filter = FilterArtwork::fromArray($request->validated());

        return view('artwork.index', [
            'artworks' => $listArtwork->list($filter),
            'filter' => $filter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArtworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtworkRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artwork  $artwork
     * @return \Illuminate\Http\Response
     */
    public function show(Artwork $artwork)
    {
        return view('artwork.show', [
            'artwork' => $artwork,
            'images' => $artwork->images()->wherePivot('is_primary', false)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artwork  $artwork
     * @return \Illuminate\Http\Response
     */
    public function edit(Artwork $artwork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArtworkRequest  $request
     * @param  \App\Models\Artwork  $artwork
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtworkRequest $request, Artwork $artwork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artwork  $artwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artwork $artwork)
    {
        //
    }
}
