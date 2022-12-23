@extends('layouts.base')

@section('body')
    <header id="header">
        <div class="container">
            <nav id="nav">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                </ul>
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
