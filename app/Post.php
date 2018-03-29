<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'name', 'slug','excerpt', 'body', 'status', 'file'
    ];

    //pertence aun usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //pertenece a una categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //tiene y pertenece a muchos tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
