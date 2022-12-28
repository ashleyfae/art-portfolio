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

    <footer id="footer" class="container">
        <div class="colour--subtitle">&copy; {{ date('Y') }} Ashley Gibson. All Rights Reserved.</div>
    </footer>
@endsection
