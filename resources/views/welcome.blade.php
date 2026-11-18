
@extends('layouts.app')

@section('title', 'Watch ' . $match->title . ' | HamroTv')

@section('content')

<div class="max-w-7xl mx-auto px-5 py-8">

    <a href="{{ route('sports.home') }}"
       class="text-gray-400 hover:text-red-500 mb-6 inline-block">
        ← Back to Home
    </a>

    <div class="grid lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2">

            <div class="bg-black rounded-xl overflow-hidden border border-gray-800">

                <div id="player-container"
                     class="relative aspect-video bg-black">

                    <div id="player-message"
                         class="absolute inset-0 flex items-center justify-center text-center p-6 z-10">

                        <div>
                            <div class="text-5xl mb-4">📺</div>

                            <h2 id="player-status" class="text-xl font-bold">
                                Preparing stream...
                            </h2>

                            <p id="player-description" class="text-gray-400 mt-2">
                                Connecting to the primary stream.
                            </p>

                            <button id="retry-button"
                                    onclick="retryCurrentStream()"
                                    class="hidden mt-4 bg-red-600 hover:bg-red-700 px-5 py-2 rounded-lg font-bold">
                                TRY AGAIN
                            </button>
                        </div>

                    </div>

                    <video id="video-player"
                           class="video-js vjs-big-play-centered w-full h-full"
                           controls
                           preload="auto"
                           playsinline
                           style="display:none">
                    </video>

                    <iframe id="iframe-player"
                            class="w-full h-full"
                            style="display:none"
                            allowfullscreen
                            allow="autoplay; encrypted-media; picture-in-picture">
                    </iframe>

                </div>

            </div>

            <div class="mt-6">

                <h1 class="text-2xl font-bold">
                    {{ $match->title }}
                </h1>

                <p class="text-gray-400 mt-2">
                    {{ $match->competition }}
                    | {{ ucfirst($match->sport_type) }}
                    | {{ ucfirst($match->status) }}
                </p>

                <div class="flex justify-between items-center mt-6 bg-[#111827] rounded-xl p-5">

                    <div class="text-center">
                        <h3 class="font-bold">{{ $match->home_team }}</h3>
                    </div>

                    <span class="text-red-500 font-black text-2xl">VS</span>

                    <div class="text-center">
                        <h3 class="font-bold">{{ $match->away_team }}</h3>
                    </div>

                </div>

            </div>

        </div>

        <aside class="bg-[#111827] rounded-xl p-5 border border-gray-800">

            <h2 class="text-xl font-bold mb-5">Available Streams</h2>

            <div class="space-y-3">

                @forelse($match->streams as $stream)

                    <button
                        type="button"
                        onclick="selectStream({{ $loop->index }})"
                        class="w-full text-left bg-gray-800 hover:bg-red-700 p-4 rounded-lg transition">

                        <div class="flex justify-between items-center">

                            <span class="font-bold">
                                {{ $stream->name }}
                            </span>

                            @if($stream->is_primary)
                                <span class="text-xs bg-red-600 px-2 py-1 rounded">
                                    PRIMARY
                                </span>
                            @else
                                <span class="text-xs bg-gray-700 px-2 py-1 rounded">
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

@push('styles')
<link href="https://vjs.zencdn.net/8.23.4/video-js.css" rel="stylesheet">
@endpush

@push('scripts')

<script src="https://vjs.zencdn.net/8.23.4/video.min.js"></script>

<script>

    // Active streams supplied by Laravel.
    const streams = @js(
        $match->streams->map(fn ($stream) => [
            'name' => $stream->name,
            'url' => $stream->stream_url,
            'type' => $stream->player_type,
            'primary' => (bool) $stream->is_primary,
        ])->values()
    );

    let videoPlayer = null;
    let currentIndex = -1;
    let timeoutId = null;
    let attemptNumber = 0;
    let isManualSelection = false;
    let hasStarted = false;

    const video = document.getElementById('video-player');
    const iframe = document.getElementById('iframe-player');
    const message = document.getElementById('player-message');
    const statusText = document.getElementById('player-status');
    const description = document.getElementById('player-description');
    const retryButton = document.getElementById('retry-button');

    function showMessage(title, text, showRetry = false) {
        message.style.display = 'flex';
        statusText.textContent = title;
        description.textContent = text;
        retryButton.classList.toggle('hidden', !showRetry);
    }

    function hideMessage() {
        message.style.display = 'none';
    }

    function clearStreamTimeout() {
        if (timeoutId) {
            clearTimeout(timeoutId);
            timeoutId = null;
        }
    }

    function getOrderedStreams() {
        return streams
            .map((stream, index) => ({ ...stream, originalIndex: index }))
            .sort((a, b) => {
                return Number(b.primary) - Number(a.primary)
                    || a.originalIndex - b.originalIndex;
            });
    }

    const orderedStreams = getOrderedStreams();

    function initializePlayer() {
        if (videoPlayer) return;

        videoPlayer = videojs('video-player');

        videoPlayer.on('playing', function () {
            clearStreamTimeout();
            hasStarted = true;
            hideMessage();
        });

        videoPlayer.on('error', function () {
            if (!isManualSelection) {
                tryNextStream();
            } else {
                clearStreamTimeout();
                showMessage(
                    'Stream failed',
                    'This stream could not play. Select another stream or retry.',
                    true
                );
            }
        });
    }

    function startStream(index, manual = false) {

        clearStreamTimeout();

        if (index < 0 || index >= orderedStreams.length) {
            showMessage(
                'All streams unavailable',
                'We could not start any of the available video streams.',
                true
            );
            return;
        }

        currentIndex = index;
        isManualSelection = manual;
        hasStarted = false;

        const stream = orderedStreams[index];

        video.style.display = 'none';
        iframe.style.display = 'none';

        if (videoPlayer) {
            videoPlayer.pause();
            videoPlayer.reset();
        }

        if (stream.type === 'iframe') {

            showMessage(
                'Opening ' + stream.name,
                'The provider is opening. Playback cannot always be verified automatically.'
            );

            iframe.src = stream.url;
            iframe.style.display = 'block';

            // Cross-origin iframe playback cannot be reliably
            // detected by the parent page.
            return;
        }

        initializePlayer();

        showMessage(
            'Connecting to ' + stream.name,
            'Please wait while we check the stream.'
        );

        video.style.display = 'block';

        const isHls = stream.url.toLowerCase().includes('.m3u8');

        videoPlayer.src({
            src: stream.url,
            type: isHls
                ? 'application/x-mpegURL'
                : 'video/mp4'
        });

        // If playback has not started within 15 seconds,
        // try the next stream.
        timeoutId = setTimeout(function () {
            if (!hasStarted && !isManualSelection) {
                tryNextStream();
            }
        }, 15000);

        videoPlayer.ready(function () {
            videoPlayer.play().catch(function () {
                // Browser autoplay may be blocked.
                // Wait for the visitor to press the play button.
                clearStreamTimeout();

                showMessage(
                    'Tap play to start',
                    'Your browser requires a click before playback can begin.'
                );
            });
        });
    }

    function tryNextStream() {

        if (isManualSelection) return;

        clearStreamTimeout();

        const nextIndex = currentIndex + 1;

        if (nextIndex >= orderedStreams.length) {
            showMessage(
                'All streams unavailable',
                'Primary and backup video streams could not be started.',
                true
            );
            return;
        }

        startStream(nextIndex, false);
    }

    function selectStream(originalIndex) {
        const index = orderedStreams.findIndex(
            stream => stream.originalIndex === originalIndex
        );

        if (index !== -1) {
            startStream(index, true);
        }
    }

    function retryCurrentStream() {
        isManualSelection = false;
        startStream(0, false);
    }

    // Start the primary stream automatically.
    if (orderedStreams.length > 0) {
        startStream(0, false);
    } else {
        showMessage(
            'No streams available',
            'Please check the stream settings in the admin panel.'
        );
    }

</script>

@endpush
