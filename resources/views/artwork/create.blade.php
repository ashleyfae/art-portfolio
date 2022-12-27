@extends('layouts.app')

@section('main')
    <h1>New Artwork</h1>

    <form method="POST" action="{{ route('artworks.store') }}" enctype="multipart/form-data">
        @csrf

        @include('artwork.partials._artwork-form', ['artwork' => $artwork])

        <p>
            <button
                type="submit"
                class="button"
            >Create</button>
        </p>
    </form>
@endsection
