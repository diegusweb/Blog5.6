<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'body'
    ];

    //una categoria puede tener n cantidad de post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
