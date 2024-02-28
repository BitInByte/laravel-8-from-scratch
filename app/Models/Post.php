<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeFilter($query, $filters) // Post::newQuery()->filter()
    {// if ($filters['search'] ?? false) {
        // instead of using an if, we can also use something like this
        $query->when($filters['search'] ?? false, fn ($query, $search) =>
            $query->where('title', 'like', '%'.$search.'%')
            ->orWhere('body', 'like', '%'.$search.'%')
        );
        // }
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
