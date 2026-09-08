<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light">

        <title>{{ $book['title'] }} — Book Review</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">
        <header class="sticky top-0 z-10 backdrop-blur bg-[#FDFDFC]/90 border-b-2 border-[#111111] shadow-sm">
            <nav class="w-full max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
                <a href="/" class="font-extrabold text-2xl sm:text-3xl tracking-tight text-[#111111]">📚 Book Review</a>
                <span class="text-base sm:text-lg font-medium text-[#111111] hidden sm:inline">Temukan rekomendasi buku terbaik</span>
            </nav>
        </header>

        <main class="w-full max-w-6xl mx-auto px-6 py-12 flex-1">
            <a href="/" class="inline-flex items-center gap-2 text-sm font-medium text-[#62605b] hover:text-[#111111] transition-colors">
                ← Back to list
            </a>

            <section class="mt-8 flex flex-col gap-10 lg:flex-row">
                <div class="w-full lg:w-80 shrink-0">
                    <img
                        src="{{ asset('images/' . $book['image']) }}"
                        alt="{{ $book['title'] }}"
                        class="w-full aspect-[5/7] object-cover rounded-2xl border border-[#E3E3E0]"
                    >
                </div>

                <div class="flex-1">
                    @php
                        $full = (int) floor($book['rating']);
                        $half = ($book['rating'] - $full) >= 0.5;
                    @endphp

                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-0.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold" title="Rating {{ $book['rating'] }}">
                            @for ($i = 0; $i < $full; $i++)
                                <span>★</span>
                            @endfor
                            @if ($half)
                                <span>⯨</span>
                            @endif
                            @for ($i = $full + ($half ? 1 : 0); $i < 5; $i++)
                                <span class="text-amber-700/30">★</span>
                            @endfor
                            <span class="ml-1">{{ $book['rating'] }}</span>
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-[#62605b] text-xs font-medium">
                            {{ $book['genre'] }}
                        </span>
                    </div>

                    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">{{ $book['title'] }}</h1>
                    <p class="mt-2 text-lg text-[#62605b]">{{ $book['author'] }} · {{ $book['year'] }}</p>

                    <p class="mt-2 text-sm text-[#62605b]">{{ $book['snippet'] }}</p>

                    <div class="mt-8 border border-[#E3E3E0] rounded-2xl bg-white p-6">
                        <h2 class="text-sm font-semibold uppercase tracking-wider text-[#62605b]">Review Lengkap</h2>
                        <p class="mt-4 text-base sm:text-lg leading-relaxed text-[#1b1b18]/90">
                            {{ $book['paragraph'] }}
                        </p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="w-full max-w-6xl mx-auto px-6 py-8 border-t border-[#E3E3E0] text-sm text-[#62605b]">
            © {{ date('Y') }} Book Review. Dibuat untuk tugas Evolusi PL.
        </footer>
    </body>
</html>