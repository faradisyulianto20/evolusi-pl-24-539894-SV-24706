<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->withoutVite()->get('/');

        $response->assertStatus(200);
    }

    public function test_book_detail_page_returns_a_successful_response(): void
    {
        $response = $this->withoutVite()->get('/books/1');

        $response->assertStatus(200);
    }
}
