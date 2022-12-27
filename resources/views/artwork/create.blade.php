@extends('layouts.app')

@section('main')
    <h1>New Artwork</h1>

    <form method="POST" action="{{ route('artworks.store') }}" enctype="multipart/form-data">
        @csrf

        @include('artwork.partials._artwork-form', ['artwork' => $artwork])

        <div class="submit text-right">
            <button
                type="submit"
            >Create</button>
        </div>
    </form>
@endsection
