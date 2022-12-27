@extends('layouts.app')

@section('main')
    <h1>Edit Artwork</h1>

    <form method="POST" action="{{ route('artworks.update', $artwork) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('artwork.partials._artwork-form', ['artwork' => $artwork])

        <p>
            <button
                type="submit"
                class="button"
            >Update</button>
        </p>
    </form>
@endsection
