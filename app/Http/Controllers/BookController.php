<?php

namespace App\Http\Controllers;

use App\Data\Books;

final class BookController extends Controller
{
    public function index()
    {
        return view('books.index', [
            'books' => Books::all(),
        ]);
    }

    public function show(int $id)
    {
        $book = collect(Books::all())->firstWhere('id', $id);

        abort_if($book === null, 404);

        return view('books.show', [
            'book' => $book,
        ]);
    }
}