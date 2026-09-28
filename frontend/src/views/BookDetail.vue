<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { fetchBook } from '../api/books'

const BACKEND_URL = import.meta.env.VITE_BACKEND_URL

const route   = useRoute()
const book    = ref(null)
const loading = ref(true)
const error   = ref(null)

onMounted(async () => {
  try {
    book.value = await fetchBook(route.params.id)
  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
})

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
        <RouterLink
          to="/"
          class="font-extrabold text-2xl sm:text-3xl tracking-tight text-[#111111]"
        >
          📚 Book Review
        </RouterLink>
        <span class="text-base sm:text-lg font-medium text-[#111111] hidden sm:inline">
          Temukan rekomendasi buku terbaik
        </span>
      </nav>
    </header>

    <!-- Main -->
    <main class="w-full max-w-6xl mx-auto px-6 py-12 flex-1">
      <!-- Loading -->
      <div
        v-if="loading"
        class="text-center py-24 text-[#62605b] text-lg"
      >
        Memuat data…
      </div>

      <!-- Error -->
      <div
        v-else-if="error"
        class="text-center py-24 text-red-500"
      >
        {{ error }}
      </div>

      <!-- Detail buku -->
      <template v-else-if="book">
        <!-- Tombol kembali -->
        <RouterLink
          to="/"
          class="inline-flex items-center gap-2 text-sm font-medium text-[#62605b] hover:text-[#111111] transition-colors"
        >
          ← Back to list
        </RouterLink>

        <!-- Konten -->
        <section class="mt-8 flex flex-col gap-10 lg:flex-row">
          <!-- Cover buku -->
          <div class="w-full lg:w-80 shrink-0">
            <img
              :src="imageUrl(book.image)"
              :alt="book.name"
              class="w-full aspect-[5/7] object-cover rounded-2xl border border-[#E3E3E0]"
            >
          </div>

          <!-- Info & Review -->
          <div class="flex-1">
            <h1 class="text-4xl font-extrabold tracking-tight">
              {{ book.name }}
            </h1>
            <p class="mt-2 text-lg text-[#62605b]">
              {{ book.author }} · {{ book.year }}
            </p>
            <p class="mt-2 text-sm text-[#62605b]">
              {{ book.snippet }}
            </p>

            <!-- Rating + Genre -->
            <div class="flex items-center gap-3 mt-4">
              <span
                class="inline-flex items-center gap-0.5 px-3 py-1 rounded-full
                       bg-amber-100 text-amber-700 font-semibold"
                :title="`Rating ${book.rating}`"
              >
                <template
                  v-for="i in getStars(book.rating).full"
                  :key="'f'+i"
                >★</template>
                <template v-if="getStars(book.rating).half">⯨</template>
                <template
                  v-for="i in getStars(book.rating).empty"
                  :key="'e'+i"
                >
                  <span class="text-amber-700/30">★</span>
                </template>
                <span class="ml-1">{{ book.rating }}</span>
              </span>
              <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-[#62605b] text-xs font-medium">
                {{ book.genre }}
              </span>
            </div>

            <!-- Review lengkap -->
            <div class="mt-8 border border-[#E3E3E0] rounded-2xl bg-white p-6">
              <h2 class="text-sm font-semibold uppercase tracking-wider text-[#62605b]">
                Review Lengkap
              </h2>
              <p class="mt-4 text-base sm:text-lg leading-relaxed text-[#1b1b18]/90">
                {{ book.paragraph }}
              </p>
            </div>
          </div>
        </section>
      </template>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-6xl mx-auto px-6 py-8 border-t border-[#E3E3E0] text-sm text-[#62605b]">
      © {{ new Date().getFullYear() }} Book Review. Dibuat untuk tugas Evolusi PL.
    </footer>
  </div>
</template>
