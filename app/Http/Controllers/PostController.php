<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Map;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $maps = Map::all();

        return view('posts.index', compact('posts','maps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $map = Map::all()->first()->id;
        $post = Post::all();

        return view('posts.create', compact('map','post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $validatedData = $request->validate([
            'map_id'=> 'required|integer',
            'luas' => 'required|integer',
            'kapasitas' => 'required|integer',
            'tarif' => 'required|integer',
            'image' => 'image|file|max:3024',
        ]);

        // dd($validatedData);

        if ($request->file('image')) {
            $validatedData['image'] = $request
                ->file('image')
                ->store('images');
        }

        Post::create($validatedData);
        
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $post = Post::find($id);

        return view('maps.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $post = $request->input('result');        

        $post = Post::find($id);
        // $post = new Post;
        $post->GeoJson = $request->input('result');
        $post->update();

        return response()->json(['post'=>$post], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response('Post deleted successfully.', 200);
    }

    public function detail($id)
    {
        $map = Map::all();
        return view('posts.create')->with(['id'=> $id]);
    }
}
