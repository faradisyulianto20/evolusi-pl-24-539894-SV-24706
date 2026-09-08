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
}