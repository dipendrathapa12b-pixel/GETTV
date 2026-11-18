
<div
    class="relative overflow-hidden rounded-xl border border-gray-800
           hover:border-red-500 transition bg-[#111827] bg-cover bg-center"
    @if($match->background_image)
        style="background-image: linear-gradient(rgba(8, 11, 18, 0.78), rgba(8, 11, 18, 0.92)), url('{{ $match->background_image }}');"
    @endif
>

    <div class="relative z-10 p-5">

        <div class="flex justify-between items-center mb-5">
            <span class="text-xs uppercase font-bold text-gray-300">
                {{ $match->sport_type === 'custom' ? $match->custom_sport_name : ucfirst($match->sport_type) }}
            </span>

            @if($match->status === 'live')
                <span class="bg-red-600 text-white text-xs px-3 py-1 rounded-full font-bold animate-pulse">
                    LIVE
                </span>
            @else
                <span class="bg-gray-700 text-white text-xs px-3 py-1 rounded-full">
                    {{ ucfirst($match->status) }}
                </span>
            @endif
        </div>

        <p class="text-sm text-gray-300 text-center mb-5">
            {{ $match->competition ?: 'Sports Match' }}
        </p>

        <div class="grid grid-cols-3 items-center text-center gap-2">

            <div>
                @if($match->home_team_logo)
                    <img src="{{ $match->home_team_logo }}"
                         alt="{{ $match->home_team }}"
                         class="w-16 h-16 object-contain mx-auto mb-2">
                @endif

                <h3 class="font-bold text-white text-sm">
                    {{ $match->home_team }}
                </h3>
            </div>

            <div class="text-red-400 font-black text-2xl">VS</div>

            <div>
                @if($match->away_team_logo)
                    <img src="{{ $match->away_team_logo }}"
                         alt="{{ $match->away_team }}"
                         class="w-16 h-16 object-contain mx-auto mb-2">
                @endif

                <h3 class="font-bold text-white text-sm">
                    {{ $match->away_team }}
                </h3>
            </div>

        </div>

        <div class="border-t border-gray-600 mt-5 pt-4 text-center">

            <p class="text-gray-200 text-sm">
                {{ $match->match_date?->format('d M Y') }}

                @if($match->match_time)
                    | {{ \Carbon\Carbon::parse($match->match_time)->format('h:i A') }}
                @endif
            </p>

            <a href="{{ route('sports.watch', $match->id) }}"
               class="block mt-4 w-full text-center
               {{ $match->status === 'live' ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-700 hover:bg-gray-600' }}
               py-2 rounded-lg font-bold text-white transition">

                @if($match->status === 'live')
                    WATCH LIVE
                @elseif($match->status === 'finished')
                    MATCH FINISHED
                @else
                    VIEW MATCH
                @endif

            </a>

        </div>

    </div>
</div>
