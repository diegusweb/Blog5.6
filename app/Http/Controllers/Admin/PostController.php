<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * TagController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::orderBy('id', 'DESC')
            ->where("user_id", auth()->user()->id)
            ->paginate();

        return view('Admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name','DESC')->pluck('name','id');
        $tags = Tag::orderBy('name','ASC')->get();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $tag = Post::create($request->all());
        //Image
        if($request->file('file')){
            $path = Storage::disk('public')->put('image', $request->file('file'));
            $tag->fill(['file' => asset($path)])->save();
        }

        //TAG, sync que se csincronize entre post y etiquetas
        $tag->tags()->sync($request->get('tags'));

        return redirect()->route('posts.edit', $tag->id)
        ->with('info', 'Entrada creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $this->authorize('pass', $post);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $this->authorize('pass', $post);

        $categories = Category::orderBy('name','ASC')->pluck('name','id');
        $tags = Tag::orderBy('name','ASC')->get();

        return view('admin.posts.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $posts = Post::find($id);
        $this->authorize('pass', $posts);
        $posts->fill($request->all())->save();

        //Image
        if($request->file('file')){
            $path = Storage::disk('public')->put('image', $request->file('file'));
            $posts->fill(['file' => asset($path)])->save();
        }

        //TAG, sync que se csincronize entre post y etiquetas
        $posts->tags()->sync($request->get('tags'));


        return redirect()->route('posts.edit', $posts->id)
            ->with('info', 'Entrada actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id)->delete();
        $this->authorize('pass', $post);
        return back()->with('info', 'Eliminado correctamente');
    }
}
