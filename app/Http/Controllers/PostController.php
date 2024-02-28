<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // DB::listen(function ($query) {
        //     // Log::info('foo');
        //     // or
        //     logger($query->sql, $query->bindings);
        // });


        return view('posts.index', [
            // latest sort of orders by the latest on like order by constraint
            // 'posts' => Post::latest()->with('category', 'author')->get()
            // 'posts' => Post::latest()->with(['category', 'author'])->get()
            // If we wrap what we have inside of the request, then it
            // will convert it to an associative array
            // )->get(),
            'posts' => Post::latest()->filter(
                request(['search', 'category', 'author'])
            )->paginate(6)->withQueryString(),
            // 'posts' => Post::latest()->filter(request()->only('search'))->get(),
            // 'categories' => Category::all(),
            // 'currentCategory' => Category::where('slug', request('category'))->first()
            // 'currentCategory' => Category::firstWhere('slug', request('category'))
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

}
