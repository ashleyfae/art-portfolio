@extends('layouts.app')

@section('main')
    <h1>Edit Artwork</h1>

    <form method="POST" action="{{ route('artworks.update', $artwork) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('artwork.partials._artwork-form', ['artwork' => $artwork])

        <div class="submit">
            <button
                type="submit"
            >Update</button>
        </div>
    </form>

    <hr>

    <form class="text-right" method="POST" action="{{ route('artworks.destroy', $artwork) }}">
        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="button is-danger"
        >Delete</button>
    </form>
@endsection
