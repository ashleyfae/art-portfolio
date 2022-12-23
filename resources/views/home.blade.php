@extends('layouts.app')

@section('main')
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
