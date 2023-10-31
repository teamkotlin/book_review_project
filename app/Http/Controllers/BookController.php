<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');
        $books = Book::when($title, function ($query, $title) {
            $query->title($title);
        })->popular()->highestRated();
        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highesRatedtLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books->latest()
        };
        //$books = $books->get();
        $cacheKey = 'books:' . $title . ':filter';
        $books = cache()->remember($cacheKey, 3600, fn() => $books->get());
        return view('books.index', compact('books'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {

        $cacheKey = 'book:' . $id;
        //return view('books.show', ['book' => $book->load(['reviews' => fn($query) => $query->latest()])]);
        $book = cache()->remember($cacheKey, 3600, fn() => Book::with(['reviews' => fn($query) => $query->latest()])->withAvgRating()->withReviewsCount()->find($id));

        return view('books.show', ['book' => $book]);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
