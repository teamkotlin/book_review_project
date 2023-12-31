<?php

use App\Http\Controllers\BookController;
use App\Http\Requests\TaskRequest;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::post('/', function (TaskRequest $request) {
    //Task::create($request->validated());
    return view('tasks')->with('success', 'Data is Fetched Successfully.');
})->name('data');
Route::get('/', function () {
    return view('tasks');
    return redirect()->route('books.index');
    //$book = Book::with('reviews_count')->find(102);
    //return $book;
    //$reviews_count = Book::withCount('reviews')->withAvg('reviews', 'rating')->latest()->having('reviews_count', '>', 10)->orderBy('reviews_count', 'desc')->get();
    //$reviews_count = Book::popular()->highestRated()->having('reviews_count', '>', 10)->having('reviews_avg_rating', '>', '3')->get();
    //return $reviews_count;
    return Book::popular('2023-01-10', '2023-03-30')->minReviews(5)->get();
    return Book::with('reviews')->title('delectus')->get();
    return view('welcome');
});
Route::resource('books', BookController::class);
