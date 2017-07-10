<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests\Menus\StoreMenuRequest;
use App\Lesson;
use App\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Menu::class);

        $menus = Menu::all();

        return view('menus.index', compact('menus'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $options = new \Illuminate\Support\Collection();
        $options = $options->merge(Collection::all());
        $options = $options->merge(Lesson::all());

        return view('menus.create', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request) {
        Menu::create([
            'title'         => $request->get('title'),
            'url'           => $request->get('url'),
            'has_menu_type' => $request->get('type'),
            'has_menu_id'   => $request->get('id'),
            'is_active'     => $request->get('is_active')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
