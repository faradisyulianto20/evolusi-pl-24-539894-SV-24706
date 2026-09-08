<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light">

        <title>Book Review</title>

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
            <section class="mb-12">
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                    Rekomendasi Buku<br>
                    <span class="text-[#111111]">Pilihan Terbaik</span>
                </h1>
                <p class="text-[#62605b] mt-4 max-w-xl text-lg leading-relaxed">
                    Kumpulan review jujur dari buku-buku yang wajib kamu baca, dari self development hingga programming.
                </p>
                <p class="mt-4 text-base text-[#62605b]">
                    {{ count($books) }} buku · {{ collect($books)->pluck('genre')->unique()->count() }} genre · rata-rata rating {{ number_format(collect($books)->avg('rating'), 1) }} ⭐
                </p>
            </section>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($books as $book)
                    <article class="group bg-white border border-[#E3E3E0] rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:border-amber-500/40 transition-all duration-300 flex flex-col cursor-pointer">
                        <div class="overflow-hidden p-3 bg-gray-100">
                            <img
                                src="{{ asset('images/' . $book['image']) }}"
                                alt="{{ $book['title'] }}"
                                class="w-full aspect-[5/7] object-cover rounded-xl group-hover:scale-105 transition-transform duration-500"
                            >
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center gap-2">
                                @php
                                    $full = (int) floor($book['rating']);
                                    $half = ($book['rating'] - $full) >= 0.5;
                                @endphp
                                <span class="inline-flex items-center gap-0.5 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700 text-sm font-semibold" title="Rating {{ $book['rating'] }}">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-gray-100 text-[#62605b] text-xs font-medium">
                                    {{ $book['genre'] }}
                                </span>
                            </div>
                            <h2 class="mt-3 font-bold text-xl leading-snug tracking-tight">{{ $book['title'] }}</h2>
                            <p class="text-sm text-[#62605b] mt-1">{{ $book['author'] }} · {{ $book['year'] }}</p>
                            <p class="mt-3 text-sm leading-relaxed text-[#1b1b18]/80 flex-1">
                                {{ $book['snippet'] }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </section>
        </main>

        <footer class="w-full max-w-6xl mx-auto px-6 py-8 border-t border-[#E3E3E0] text-sm text-[#62605b]">
            © {{ date('Y') }} Book Review. Dibuat untuk tugas Evolusi PL.
        </footer>
    </body>
</html>