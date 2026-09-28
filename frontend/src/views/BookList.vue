<script setup>
import { ref, onMounted, computed } from 'vue'
import { fetchBooks } from '../api/books'

// URL base Laravel untuk aset gambar (bukan URL API)
const BACKEND_URL = import.meta.env.VITE_BACKEND_URL

const books  = ref([])
const loading = ref(true)
const error   = ref(null)

onMounted(async () => {
  try {
    books.value = await fetchBooks()
  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
})

// Statistik ringkasan
const totalGenres  = computed(() => new Set(books.value.map(b => b.genre)).size)
const averageRating = computed(() => {
  if (!books.value.length) return 0
  return (books.value.reduce((sum, b) => sum + parseFloat(b.rating), 0) / books.value.length).toFixed(1)
})

// Hitung bintang dari nilai rating
function getStars(rating) {
  const full  = Math.floor(rating)
  const half  = (rating - full) >= 0.5
  const empty = 5 - full - (half ? 1 : 0)
  return { full, half, empty }
}

function imageUrl(image) {
  return `${BACKEND_URL}/images/${image}`
}
</script>

<template>
  <div class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- Header -->
    <header class="sticky top-0 z-10 backdrop-blur bg-[#FDFDFC]/90 border-b-2 border-[#111111] shadow-sm">
      <nav class="w-full max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="/" class="font-extrabold text-2xl sm:text-3xl tracking-tight text-[#111111]">
          📚 Book Review
        </a>
        <span class="text-base sm:text-lg font-medium text-[#111111] hidden sm:inline">
          Temukan rekomendasi buku terbaik
        </span>
      </nav>
    </header>

    <!-- Main -->
    <main class="w-full max-w-6xl mx-auto px-6 py-12 flex-1">

      <!-- Hero section -->
      <section class="mb-12">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
          Rekomendasi Buku<br>
          <span class="text-[#111111]">Pilihan Terbaik</span>
        </h1>
        <p class="text-[#62605b] mt-4 max-w-xl text-lg leading-relaxed">
          Kumpulan review jujur dari buku-buku yang wajib kamu baca,
          dari self development hingga programming.
        </p>
        <p v-if="books.length" class="mt-4 text-base text-[#62605b]">
          {{ books.length }} buku · {{ totalGenres }} genre · rata-rata rating {{ averageRating }} ⭐
        </p>
      </section>

      <!-- Loading -->
      <div v-if="loading" class="text-center py-24 text-[#62605b] text-lg">
        Memuat data…
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-24 text-red-500">
        {{ error }}
      </div>

      <!-- Grid buku -->
      <section v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <RouterLink
          v-for="book in books"
          :key="book.id"
          :to="`/books/${book.id}`"
          class="group bg-white border border-[#E3E3E0] rounded-2xl overflow-hidden shadow-sm
                 hover:shadow-xl hover:border-amber-500/40 transition-all duration-300 flex flex-col cursor-pointer"
        >
          <!-- Cover -->
          <div class="overflow-hidden p-3 bg-gray-100">
            <img
              :src="imageUrl(book.image)"
              :alt="book.name"
              class="w-full aspect-[5/7] object-cover rounded-xl group-hover:scale-105 transition-transform duration-500"
            />
          </div>

          <!-- Info -->
          <div class="p-5 flex flex-col flex-1">
            <!-- Rating + Genre -->
            <div class="flex items-center gap-2">
              <span
                class="inline-flex items-center gap-0.5 px-2.5 py-0.5 rounded-full
                       bg-amber-100 text-amber-700 text-sm font-semibold"
                :title="`Rating ${book.rating}`"
              >
                <template v-for="i in getStars(book.rating).full" :key="'f'+i">★</template>
                <template v-if="getStars(book.rating).half">⯨</template>
                <template v-for="i in getStars(book.rating).empty" :key="'e'+i">
                  <span class="text-amber-700/30">★</span>
                </template>
                <span class="ml-1">{{ book.rating }}</span>
              </span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-gray-100 text-[#62605b] text-xs font-medium">
                {{ book.genre }}
              </span>
            </div>

            <!-- Judul -->
            <h2 class="mt-3 font-bold text-xl leading-snug tracking-tight">{{ book.name }}</h2>
            <p class="text-sm text-[#62605b] mt-1">{{ book.author }} · {{ book.year }}</p>
            <p class="mt-3 text-sm leading-relaxed text-[#1b1b18]/80 flex-1">{{ book.snippet }}</p>
          </div>
        </RouterLink>
      </section>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-6xl mx-auto px-6 py-8 border-t border-[#E3E3E0] text-sm text-[#62605b]">
      © {{ new Date().getFullYear() }} Book Review. Dibuat untuk tugas Evolusi PL.
    </footer>

  </div>
</template>
