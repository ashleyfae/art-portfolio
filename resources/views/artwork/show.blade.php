@extends('layouts.app')

@section('main')
    <div id="artwork">
        @if($artwork->primaryImage->title)
            <h1>{{ $artwork->primaryImage->title }}</h1>
        @endif

        @can('update', $artwork)
            <ul class="navbar">
                <li>
                    <a href="{{ route('artworks.edit', $artwork) }}">Edit</a>
                </li>
            </ul>
        @endcan

        <figure class="text-center">
            <img
                src="{{ $artwork->primaryImage->imageUrl }}"
                alt="{{ $artwork->primaryImage->alt_text }}"
            >
        </figure>

        @if($artwork->primaryImage->description)
            {!! ($artwork->primaryImage->description) !!}
        @endif

        @if($images->isNotEmpty())
            <div id="artwork-images">
                @foreach($images as $image)
                    @if($image->title)
                        <h2>{{ $image->title }}</h2>
                    @endif

                    <figure class="text-center">
                        <img
                            src="{{ $image->imageUrl }}"
                            alt="{{ $image->alt_text }}"
                        >
                    </figure>

                    @if($image->description)
                        {!! ($image->description) !!}
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
