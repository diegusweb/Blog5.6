<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];

    //una tag tiene o pertenece a muchos post, porque e suna relacion muchos a muchos
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
