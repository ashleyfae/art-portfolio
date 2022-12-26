@extends('layouts.app')

@section('main')
<nav id="gallery-nav" role="navigation">
    <ul class="navbar">
        <li>
            <button
                type="button"
                id="artwork-filter"
                class="has-dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            ></button>
        </li>
    </ul>
</nav>

<div class="gallery">
    @foreach($artworks as $artwork)
        <div class="gallery--item">
            <a href="{{ $artwork->path }}">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::url($artwork->primaryImage->image_path) }}"
                    alt="{{ $artwork->primaryImage->alt_text }}"
                >
            </a>
        </div>
    @endforeach
</div>
@endsection
