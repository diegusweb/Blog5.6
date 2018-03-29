<?php

namespace App\Http\Controllers\Web;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function blog(){
        $posts = Post::orderBy('id', 'DESC')->where('status','PUBLISHED')->paginate(3);

        return view("web.posts", compact('posts'));
    }

    public function post($slug){
        $post = Post::where('slug', $slug)->first();

        return view('web.post', compact('post'));
    }
}
