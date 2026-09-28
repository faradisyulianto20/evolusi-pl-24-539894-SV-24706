/**
 * Semua request ke Laravel API terpusat di sini.
 * URL base diambil dari VITE_API_URL di file .env (tidak hardcode).
 *
 * Di Vite, hanya variabel dengan prefix VITE_ yang di-expose ke browser.
 * Akses via: import.meta.env.VITE_API_URL
 */
const BASE_URL = import.meta.env.VITE_API_URL

/**
 * Ambil semua produk (data buku) dari Laravel.
 * @returns {Promise<Array>}
 */
export async function fetchBooks() {
  const response = await fetch(`${BASE_URL}/products`)

  if (!response.ok) {
    throw new Error(`Gagal mengambil data: ${response.status}`)
  }

  return response.json()
}

/**
 * Ambil satu produk (buku) berdasarkan ID.
 * @param {number|string} id
 * @returns {Promise<Object>}
 */
export async function fetchBook(id) {
  const response = await fetch(`${BASE_URL}/products/${id}`)

  if (!response.ok) {
    throw new Error(`Buku tidak ditemukan: ${response.status}`)
  }

  return response.json()
}
