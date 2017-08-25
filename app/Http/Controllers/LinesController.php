<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Lines\StoreLineRequest;
use App\Http\Requests\Lines\UpdateLineRequest;
use App\Line;

class LinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Line::class);

        $lines = Line::all();

        return view("lines.index", compact('lines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Line::class);

        $categories = Category::all();

        return view('lines.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLineRequest $request) {
        Line::create([
            'name'        => $request->get("name"),
            'category_id' => $request->get("category_id"),
        ]);

        return redirect()->route('lines.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Line $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Line $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line) {
        $this->authorize('edit', Line::class);

        $categories = Category::select("id", 'name')->get();

        return view('lines.edit', compact("categories", 'line'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Line                $line
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLineRequest $request, Line $line) {
        $line->update([
            'name'        => $request->get("name"),
            'category_id' => $request->get("category_id"),
        ]);

        return redirect()->route('lines.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Line $line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Line $line) {
        $this->authorize('delete', Line::class);

        $line->delete();

        return response()->json(['status' => 'okay']);
    }
}
