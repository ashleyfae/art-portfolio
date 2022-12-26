@extends('layouts.base')

@section('body')
    <header id="header">
        <div class="container">
            <nav id="nav">
                <ul class="navbar">
                    <li>
                        <a
                            href="{{ route('home') }}"
                        >Home</a>
                    </li>
                    <li>
                        <a href="https://twitter.com/NoseGraze" target="_blank">Twitter</a>
                    </li>
                </ul>

                @can('create', App\Models\Artwork::class)
                    <ul class="navbar">
                        <li>
                            <a href="{{ route('artworks.create') }}">Create</a>
                        </li>
                    </ul>
                @endcan
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('main')
    </main>

    <footer id="footer" class="container mt-9 pt-6 pb-4">
        <div class="md:flex md:justify-between gap-2">
            <div class="colour--subtitle">&copy; Ashley Gibson.</div>
        </div>
    </footer>
@endsection
