<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product(): void
    {
        $payload = [
            'name' => 'Buku Pemrograman Web',
            'price' => 75000,
            'description' => 'Buku panduan dasar hingga mahir Laravel',
        ];

        $response = $this->postJson('/products', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Buku Pemrograman Web']);

        $this->assertDatabaseHas('products', [
            'name' => 'Buku Pemrograman Web',
        ]);
    }

    public function test_can_list_all_products(): void
    {
        Product::create(['name' => 'Produk A', 'price' => 10000]);
        Product::create(['name' => 'Produk B', 'price' => 20000]);

        $response = $this->getJson('/products');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_can_show_product_detail(): void
    {
        $product = Product::create([
            'name' => 'Produk Khusus',
            'price' => 50000,
            'description' => 'Detail produk khusus',
        ]);

        $response = $this->getJson("/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Produk Khusus']);
    }

    public function test_can_update_product(): void
    {
        $product = Product::create([
            'name' => 'Nama Lama',
            'price' => 30000,
        ]);

        $response = $this->putJson("/products/{$product->id}", [
            'name' => 'Nama Baru',
            'price' => 45000,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Nama Baru']);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Nama Baru',
            'price' => 45000,
        ]);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Produk Dihapus',
            'price' => 15000,
        ]);

        $response = $this->deleteJson("/products/{$product->id}");

        $response->assertStatus(500);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
