<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\CreatePost;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with(['comments'])->latest()->paginate(10);

        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = \Auth::user()->id;

        $post->save();

        return redirect()->route('posts.index');
    }

    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);

        return view('posts.show',[
            'post' => $post,
        ]);
    }

    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);

        return view('posts.edit',[
            'post' => $post,
        ]);
    }

    public function update($post_id, Request $request)
    {
        $params = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:200',
        ]);

        $post = Post::findOrFail($post_id);
        $post->fill($params)->save();

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
