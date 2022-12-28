<?php

namespace App\Http\Controllers;

use App\Actions\Artwork\CreateOrUpdateArtworkFromRequest;
use App\Actions\Artwork\DeleteArtwork;
use App\Actions\Artwork\ListArtwork;
use App\DataTransferObjects\FilterArtwork;
use App\Http\Requests\FilterArtworkRequest;
use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Support\Carbon;

class ArtworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FilterArtworkRequest $request, ListArtwork $listArtwork)
    {
        $filter = FilterArtwork::fromArray(array_merge($request->validated(), array_filter([
            'year' => $request->route('year'),
            'month' => $request->route('month')
        ])));

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
        return view('artwork.create', [
            'artwork' => (new Artwork())->setAttribute('is_featured', true),
            'publishedAt' => Carbon::now()->toDateTimeString(),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArtworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtworkRequest $request, CreateOrUpdateArtworkFromRequest $createArtworkFromRequest)
    {
        $artwork = $createArtworkFromRequest->execute($request);

        $request->session()->flash('success', 'Artwork created successfully');

        return redirect($artwork->refresh()->path);
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
            'images' => $artwork->galleryImages,
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
        $artwork->load(['categories']);

        return view('artwork.edit', [
            'artwork' => $artwork,
            'publishedAt' => $artwork->published_at->toDateTimeString(),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArtworkRequest  $request
     * @param  \App\Models\Artwork  $artwork
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtworkRequest $request, Artwork $artwork, CreateOrUpdateArtworkFromRequest $action)
    {
        $action->setArtwork($artwork)->execute($request);

        $request->session()->flash('success', 'Artwork updated successfully');

        return redirect($artwork->path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artwork  $artwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artwork $artwork, DeleteArtwork $action)
    {
        $action->execute($artwork);

        return redirect(route('home'));
    }
}
