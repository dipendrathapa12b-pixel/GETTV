
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO --}}
    <title>@yield('title', 'GETTV - Live Sports Streaming')</title>

    <meta name="description" content="@yield('meta_description', 'Watch live sports, football, cricket and your favorite sporting events on GETTV.')">

    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    <meta name="author" content="GETTV">

    <meta name="theme-color" content="#080b12">

    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph SEO --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="GETTV">
    <meta property="og:title" content="@yield('title', 'GETTV - Live Sports Streaming')">
    <meta property="og:description" content="@yield('meta_description', 'Watch live sports, football and cricket on GETTV.')">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter SEO --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'GETTV - Live Sports Streaming')">
    <meta name="twitter:description" content="@yield('meta_description', 'Watch live sports, football and cricket on GETTV.')">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>

<body class="bg-[#080b12] text-white min-h-screen flex flex-col overflow-x-hidden">

    {{-- Navigation --}}
    <nav class="bg-[#101722] border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-5 py-4 flex flex-wrap justify-between items-center gap-4">

            {{-- Logo --}}
            <a href="{{ route('sports.home') }}"
               class="text-xl sm:text-2xl font-black text-red-500 shrink-0"
               aria-label="GETTV Home">
                GET<span class="text-white">TV</span>
            </a>

            {{-- Navigation Links --}}
            <div class="flex flex-wrap items-center justify-center gap-x-4 sm:gap-x-5 gap-y-2 text-xs sm:text-sm font-semibold">

                <a href="{{ route('sports.home') }}"
                   class="hover:text-red-500 transition-colors">
                    Home
                </a>

                <a href="{{ route('sports.home') }}#football"
                   class="hover:text-red-500 transition-colors">
                    Football
                </a>

                <a href="{{ route('sports.home') }}#cricket"
                   class="hover:text-red-500 transition-colors">
                    Cricket
                </a>

            </div>

        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-16 border-t border-gray-800 py-8 text-center text-gray-500 px-4">

        <p class="text-sm">
            © {{ date('Y') }} GETTV. All rights reserved.
        </p>

    </footer>

    @stack('scripts')

</body>
</html>

