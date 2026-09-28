import { describe, it, expect, vi, beforeEach } from 'vitest'

// Mock fetch global sebelum import modul
const mockFetch = vi.fn()
vi.stubGlobal('fetch', mockFetch)

// Set env variable yang dibutuhkan books.js
import.meta.env.VITE_API_URL = 'http://localhost:8000/api'

// Dinamis import setelah env di-set
const { fetchBooks, fetchBook } = await import('../api/books.js')

describe('fetchBooks', () => {
  beforeEach(() => {
    mockFetch.mockReset()
  })

  it('mengembalikan array buku jika response ok', async () => {
    const dummyBooks = [{ id: 1, name: 'Clean Code', author: 'Robert C. Martin' }]

    mockFetch.mockResolvedValue({
      ok: true,
      json: () => Promise.resolve(dummyBooks),
    })

    const result = await fetchBooks()
    expect(result).toEqual(dummyBooks)
    expect(mockFetch).toHaveBeenCalledWith('http://localhost:8000/api/products')
  })

  it('melempar error jika response tidak ok', async () => {
    mockFetch.mockResolvedValue({ ok: false, status: 500 })

    await expect(fetchBooks()).rejects.toThrow('Gagal mengambil data: 500')
  })
})

describe('fetchBook', () => {
  beforeEach(() => {
    mockFetch.mockReset()
  })

  it('mengembalikan satu buku berdasarkan id', async () => {
    const dummyBook = { id: 3, name: 'The Pragmatic Programmer' }

    mockFetch.mockResolvedValue({
      ok: true,
      json: () => Promise.resolve(dummyBook),
    })

    const result = await fetchBook(3)
    expect(result).toEqual(dummyBook)
    expect(mockFetch).toHaveBeenCalledWith('http://localhost:8000/api/products/3')
  })

  it('melempar error jika buku tidak ditemukan', async () => {
    mockFetch.mockResolvedValue({ ok: false, status: 404 })

    await expect(fetchBook(999)).rejects.toThrow('Buku tidak ditemukan: 404')
  })
})
