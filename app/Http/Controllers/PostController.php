<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::with('user')->orderBy('created_at', "DESC")->get();
        // dd(PostsResource::collection($post));
        return Inertia()->render('post/index', [
            "post" => PostsResource::collection($post),
            "now" => now(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        sleep(20);
        $request->validate([
            "body" => 'required|string',
            "title" => 'required|string',
        ]);

        $data = [
            "body" => $request->body,
            "title" => $request->title,
            "user_id" => Auth()->User()->id,
        ];

        Post::create($data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "body" => 'required|string',
            "title" => 'required|string',
        ]);
        $data = [
            "body" => $request->body,
            "title" => $request->title,
        ];
        sleep(5);
        Post::where('id', $id)->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::where('id', $id)->delete();
        return redirect()->back();
    }
}
