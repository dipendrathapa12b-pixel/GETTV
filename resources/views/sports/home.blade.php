
@extends('layouts.app')

@section('title', 'GETTV - Watch Live Football & Cricket')

@section('meta_description', 'Watch live football, cricket and sports matches on GETTV. Discover upcoming matches and live sports streams.')

@section('content')

<div class="max-w-7xl mx-auto px-5 py-10">

    <section class="mb-10 rounded-2xl bg-gradient-to-r from-red-950 to-gray-900 p-8">
        <span class="text-red-400 font-bold uppercase text-sm">
            Welcome to GETTV
        </span>

        <h1 class="text-4xl md:text-5xl font-black mt-3">
            Watch Live Sports
        </h1>

        <p class="text-gray-300 mt-3">
            Follow live matches, upcoming fixtures and your favourite sports.
        </p>
    </section>

    @if($liveMatches->isNotEmpty())
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-5 text-red-500">LIVE NOW</h2>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($liveMatches as $match)
                    @include('sports.partials.match-card', ['match' => $match])
                @endforeach
            </div>
        </section>
    @endif

    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-5">Upcoming Matches</h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($upcomingMatches as $match)
                @include('sports.partials.match-card', ['match' => $match])
            @empty
                <p class="text-gray-400">No upcoming matches available.</p>
            @endforelse
        </div>
    </section>

    <section id="football" class="mb-12">
        <h2 class="text-2xl font-bold mb-5">Football</h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($footballMatches as $match)
                @include('sports.partials.match-card', ['match' => $match])
            @empty
                <p class="text-gray-400">No football matches available.</p>
            @endforelse
        </div>
    </section>

    <section id="cricket" class="mb-12">
        <h2 class="text-2xl font-bold mb-5">Cricket</h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($cricketMatches as $match)
                @include('sports.partials.match-card', ['match' => $match])
            @empty
                <p class="text-gray-400">No cricket matches available.</p>
            @endforelse
        </div>
    </section>

</div>

@endsection
