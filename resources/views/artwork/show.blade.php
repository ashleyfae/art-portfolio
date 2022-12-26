@extends('layouts.app')

@section('main')
    <div id="artwork">
        @if($artwork->primaryImage->title)
            <h1>{{ $artwork->primaryImage->title }}</h1>
        @endif

        <figure class="text-center">
            <img
                src="{{ \Illuminate\Support\Facades\Storage::url($artwork->primaryImage->image_path) }}"
                alt="{{ $artwork->primaryImage->alt_text }}"
            >
        </figure>

        @if($artwork->primaryImage->description)
            <p>{{ $artwork->primaryImage->description }}</p>
        @endif

        @if($images->isNotEmpty())
            <div id="artwork-images">
                @foreach($images as $image)
                    @if($image->title)
                        <h2>{{ $image->title }}</h2>
                    @endif

                    <figure class="text-center">
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($image->image_path) }}"
                            alt="{{ $image->alt_text }}"
                        >
                    </figure>

                    @if($image->description)
                        <p>{{ $image->description }}</p>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
