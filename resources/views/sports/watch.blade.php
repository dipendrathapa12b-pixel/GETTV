
@extends('layouts.app')

@section('title', 'Watch ' . $match->title . ' | HamroTv')

@section('meta_description', 'Watch ' . $match->title . ' live on HamroTv. Choose from available live sports streams.')

@section('content')

@php
    $primaryStream = $match->streams->firstWhere('is_primary', true)
        ?? $match->streams->first();
@endphp

<div class="max-w-7xl mx-auto px-3 sm:px-5 py-5 sm:py-8">

    {{-- Back Button --}}
    <a href="{{ route('sports.home') }}"
       class="text-gray-400 hover:text-red-500 mb-5 sm:mb-6 inline-block text-sm sm:text-base">
        ← Back to Home
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-8">

        {{-- LEFT: VIDEO AND MATCH DETAILS --}}
        <div class="lg:col-span-2 min-w-0">

            {{-- MOBILE STREAM LIST: ABOVE VIDEO --}}
            <div class="lg:hidden mb-4 bg-[#111827] rounded-xl p-4 sm:p-5 border border-gray-800">

                <h2 class="text-lg sm:text-xl font-bold mb-4">
                    Available Streams
                </h2>

                <div class="space-y-3">

                    @forelse($match->streams as $stream)

                        <button
                            type="button"
                            onclick="playStream(@js($stream->stream_url), @js($stream->player_type), this)"
                            class="stream-button w-full text-left bg-gray-800 hover:bg-red-700 p-3 sm:p-4 rounded-lg transition border border-transparent"
                            aria-label="Play {{ $stream->name }}">

                            <div class="flex justify-between items-center gap-3">

                                <span class="font-bold text-sm sm:text-base break-words">
                                    {{ $stream->name }}
                                </span>

                                @if($stream->is_primary)

                                    <span class="text-xs bg-red-600 px-2 py-1 rounded shrink-0">
                                        PRIMARY
                                    </span>

                                @else

                                    <span class="text-xs bg-gray-700 px-2 py-1 rounded shrink-0">
                                        BACKUP
                                    </span>

                                @endif

                            </div>

                        </button>

                    @empty

                        <p class="text-gray-400 text-sm">
                            No active streams are available for this match.
                        </p>

                    @endforelse

                </div>

            </div>


            {{-- VIDEO PLAYER --}}
            <div class="bg-black rounded-xl overflow-hidden border border-gray-800 shadow-lg">

                <div id="player-container"
                     class="relative w-full aspect-video flex items-center justify-center bg-black">

                    {{-- Initial Message --}}
                    <div id="player-message" class="text-center p-4 sm:p-6">

                        <div class="text-4xl sm:text-5xl mb-4">📺</div>

                        <h2 class="text-lg sm:text-xl font-bold">
                            Select a stream
                        </h2>

                        <p class="text-gray-400 mt-2 text-sm sm:text-base">
                            Choose an available stream above to start watching.
                        </p>

                    </div>

                    {{-- Video.js Player --}}
                    <video id="video-player"
                           class="video-js vjs-big-play-centered"
                           controls
                           preload="auto"
                           playsinline
                           style="display:none; position:absolute; inset:0; width:100%; height:100%;">
                    </video>

                    {{-- Iframe Player --}}
                    <iframe id="iframe-player"
                            class="absolute inset-0 w-full h-full"
                            style="display:none"
                            allowfullscreen
                            allow="autoplay; encrypted-media; picture-in-picture"
                            referrerpolicy="strict-origin-when-cross-origin"
                            title="Live Sports Stream">
                    </iframe>

                </div>

            </div>


            {{-- MATCH INFORMATION --}}
            <div class="mt-5 sm:mt-6">

                <h1 class="text-xl sm:text-2xl font-bold break-words">
                    {{ $match->title }}
                </h1>

                <p class="text-gray-400 mt-2 text-xs sm:text-sm">
                    {{ $match->competition }}
                    | {{ ucfirst($match->sport_type) }}
                    | {{ ucfirst($match->status) }}
                </p>

                {{-- TEAMS --}}
                <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-5 mt-5 sm:mt-6 bg-[#111827] rounded-xl p-4 sm:p-6">

                    <div class="text-center min-w-0">
                        <h3 class="font-bold text-sm sm:text-lg break-words">
                            {{ $match->home_team }}
                        </h3>
                    </div>

                    <span class="text-red-500 font-black text-xl sm:text-3xl">
                        VS
                    </span>

                    <div class="text-center min-w-0">
                        <h3 class="font-bold text-sm sm:text-lg break-words">
                            {{ $match->away_team }}
                        </h3>
                    </div>

                </div>

            </div>

        </div>


        {{-- RIGHT: DESKTOP STREAM LIST --}}
        <aside class="hidden lg:block bg-[#111827] rounded-xl p-5 border border-gray-800 h-fit">

            <h2 class="text-xl font-bold mb-5">
                Available Streams
            </h2>

            <div class="space-y-3">

                @forelse($match->streams as $stream)

                    <button
                        type="button"
                        onclick="playStream(@js($stream->stream_url), @js($stream->player_type), this)"
                        class="stream-button w-full text-left bg-gray-800 hover:bg-red-700 p-4 rounded-lg transition border border-transparent"
                        aria-label="Play {{ $stream->name }}">

                        <div class="flex justify-between items-center gap-2">

                            <span class="font-bold break-words">
                                {{ $stream->name }}
                            </span>

                            @if($stream->is_primary)

                                <span class="text-xs bg-red-600 px-2 py-1 rounded shrink-0">
                                    PRIMARY
                                </span>

                            @else

                                <span class="text-xs bg-gray-700 px-2 py-1 rounded shrink-0">
                                    BACKUP
                                </span>

                            @endif

                        </div>

                    </button>

                @empty

                    <p class="text-gray-400">
                        No active streams are available for this match.
                    </p>

                @endforelse

            </div>

        </aside>

    </div>

</div>

@endsection


{{-- VIDEO PLAYER STYLES --}}
@push('styles')

<link href="https://vjs.zencdn.net/8.23.4/video-js.css" rel="stylesheet">

<style>

    .video-js {
        position: absolute !important;
        inset: 0;
        width: 100% !important;
        height: 100% !important;
    }

    .video-js .vjs-tech {
        object-fit: contain;
    }

    .stream-button.active {
        background-color: #991b1b;
        border-color: #ef4444;
    }

</style>

@endpush


{{-- VIDEO PLAYER SCRIPTS --}}
@push('scripts')

<script src="https://vjs.zencdn.net/8.23.4/video.min.js"></script>

<script>

    let videoPlayer = null;

    // PLAY SELECTED STREAM
    function playStream(url, playerType, button = null) {

        const video = document.getElementById('video-player');
        const iframe = document.getElementById('iframe-player');
        const message = document.getElementById('player-message');

        if (!url) {
            console.error('Stream URL is missing.');
            return;
        }

        // Hide initial message
        message.style.display = 'none';

        // Stop previous video
        if (videoPlayer) {
            videoPlayer.pause();
            videoPlayer.reset();
        }

        // Stop previous iframe
        iframe.src = 'about:blank';

        // Hide both players
        video.style.display = 'none';
        iframe.style.display = 'none';

        // Highlight selected stream
        document.querySelectorAll('.stream-button').forEach(btn => {
            btn.classList.remove('active');
        });

        if (button) {
            button.classList.add('active');
        }

        // IFRAME STREAM
        if (playerType === 'iframe') {

            iframe.src = url;
            iframe.style.display = 'block';

            return;
        }

        // DIRECT VIDEO STREAM
        video.style.display = 'block';

        if (!videoPlayer) {
            videoPlayer = videojs('video-player');
        }

        let videoType = 'video/mp4';

        if (url.includes('.m3u8')) {
            videoType = 'application/x-mpegURL';
        } else if (url.includes('.mpd')) {
            videoType = 'application/dash+xml';
        }

        videoPlayer.src({
            src: url,
            type: videoType
        });

        videoPlayer.ready(function () {

            videoPlayer.play().catch(function (error) {
                console.log('Autoplay blocked. Press the play button.', error);
            });

        });

    }


    // AUTOMATICALLY PLAY PRIMARY STREAM
    document.addEventListener('DOMContentLoaded', function () {

        @if($primaryStream)

            const primaryUrl = @js($primaryStream->stream_url);
            const primaryType = @js($primaryStream->player_type);
            const primaryName = @js($primaryStream->name);

            // Find the primary stream button
            const primaryButton = Array.from(
                document.querySelectorAll('.stream-button')
            ).find(button => {
                return button.getAttribute('aria-label') ===
                    'Play ' + primaryName;
            });

            // Start primary stream
            playStream(primaryUrl, primaryType, primaryButton);

        @endif

    });

</script>

@endpush

