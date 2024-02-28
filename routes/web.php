<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

Route::get('/', function () {
    // DB::listen(function ($query) {
    //     // Log::info('foo');
    //     // or
    //     logger($query->sql, $query->bindings);
    // });
    return view('posts', [
        // latest sort of orders by the latest on like order by constraint
        // 'posts' => Post::latest()->with('category', 'author')->get()
        // 'posts' => Post::latest()->with(['category', 'author'])->get()
        'posts' => Post::latest()->get(),
        'categories' => Category::all()
    ]);
})->name('home');

Route::get('posts/{post:slug}', function (Post $post) { // Post::where('slug', $post)->firstOrFail();
    return view('post', [
        'post' => $post
    ]);
});

Route::get('categories/{category:slug}', function (Category $category) {
    return view('posts', [
        // 'post' => $category->posts->load(['category', 'author']),
        'posts' => $category->posts,
        'currentCategory' => $category,
        'categories' => Category::all()
    ]);
})->name('category');

Route::get('authors/{author:username}', function (User $author) {
    return view('posts', [
        // 'post' => $author->posts->load(['category', 'author']),
        'posts' => $author->posts,
        'categories' => Category::all()
    ]);
});
