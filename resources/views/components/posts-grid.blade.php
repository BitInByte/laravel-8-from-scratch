@props(['posts'])
<x-post-featured-card :post="$posts[0]" />
@if ($posts->count() > 1)
    <div class="lg:grid lg:grid-cols-6">
        <!-- Since we have a collection, we can use -->
        <!-- skip to skip the first one since is the one -->
        <!-- we use on the featured card -->
        @foreach ($posts->skip(1) as $post)
            <x-post-card
                :post="$post"
                class="{{ $loop->iteration < 3 ? 'col-span-3' : 'col-span-2' }}"
            />
        @endforeach
    </div>
@endif
