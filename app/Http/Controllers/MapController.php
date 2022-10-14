<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\Category;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $map = Map::all();

        return view('maps.index', compact('map'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $map = Map::all();
        $categories = Category::all();

        return view('maps.create', compact('map','categories'));
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
        $map = new Map;
        $map->category_id = $request->category_id;
        $map->title = $request->title;
        $map->status = $request->status;
        $map->geojson = $request->input('result');

        $map->save();

        return response()->json(['map'=>$map], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $map = Map::find($id);

        return view('maps.edit', compact('map'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $map = $request->input('result');        

        $map = Map::find($id);
        // $map = new map;
        $map->status = $request->status;
        $map->geojson = $request->input('result');
        $map->update();

        return response()->json(['map'=>$map], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $map = Map::findOrFail($id);
        $map->delete();

        return response('map deleted successfully.', 200);
    }

    public function detail($id)
    {
        $map = Map::all();
        return view('maps.atribut')->with(['id'=> $id]);
    }
}
