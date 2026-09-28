<?php

namespace Database\Seeders;

use App\Data\Books;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed produk dengan data buku statis dari Books.php
        foreach (Books::all() as $book) {
            Product::create([
                'name'        => $book['title'],
                'author'      => $book['author'],
                'genre'       => $book['genre'],
                'year'        => $book['year'],
                'rating'      => $book['rating'],
                'price'       => (int) ($book['rating'] * 10000), // harga simbolis
                'image'       => $book['image'],
                'snippet'     => $book['snippet'],
                'description' => $book['snippet'],
                'paragraph'   => $book['paragraph'],
            ]);
        }
    }
}

