<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'excerpt', 'body'];
    // protected $guarded = ['id'];
    // protected $guarded = [];

    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }
    protected $with = ['category', 'author'];

    public function scopeFilter(Builder $query, $filters) // Post::newQuery()->filter()
    {// if ($filters['search'] ?? false) {
        // instead of using an if, we can also use something like this
        $query->when($filters['search'] ?? false, fn ($query, $search) =>
            $query->where(fn($query) =>
                $query
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('body', 'like', '%'.$search.'%')
            )
        );
        // $query
        // ->whereExists(fn($query) =>
        //     $query
        //         ->from('categories')
        //         ->whereColumn('categories.id', 'posts.category_id')
        //         ->where('categories.slug', $category)
        // )
        $query->when($filters['category'] ?? false, fn ($query, $category) =>
            $query->whereHas('category', fn($query) => $query->where('slug', $category))
        );
        // }

        $query->when($filters['author'] ?? false, fn ($query, $author) =>
            $query->whereHas('author', fn($query) => $query->where('username', $author))
        );
    }

    public function category()
    {
        // hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
