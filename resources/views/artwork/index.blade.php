@extends('layouts.app')

@section('main')
<nav id="gallery-nav" role="navigation">
    <ul class="navbar">
        <li>
            <a
                href="{{ route('home', ['show_all' => true]) }}"
                @class(['button', 'is-active' => $filter->showAll])
            >All Artwork</a>
        </li>
        <li>
            <a
                href="{{ route('home', ['show_all' => false]) }}"
                @class(['button', 'is-active' => ! $filter->showAll])
            >Featured</a>
        </li>
    </ul>
</nav>

@if($artworks->isNotEmpty())
    <div class="gallery">
        @foreach($artworks as $artwork)
            <div class="gallery--item">
                <a href="{{ $artwork->path }}">
                    <img
                        src="{{ $artwork->primaryImage->imageUrl }}"
                        alt="{{ $artwork->primaryImage->alt_text }}"
                    >
                </a>
            </div>
        @endforeach
    </div>

    {{ $artworks->withQueryString()->links() }}
@else
    <p class="text-center">No artwork found.</p>
@endif
@endsection
