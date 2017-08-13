<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tests\StoreTestRequest;
use App\Http\Requests\Tests\UpdateTestRequest;
use App\Test;
use App\User;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->authorize('view', Test::class);

        $tests = Test::all();

        return view('tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Test::class);

        return view('tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestRequest $request) {
        Test::create([
            'title'           => $request->get('title'),
            'question_number' => $request->get('question_number')
        ]);

        return redirect()->route('tests.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $this->authorize('show', Test::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test) {
        $this->authorize('edit', Test::class);

        return view('tests.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestRequest $request, Test $test) {

        $test->update([
            'title'           => $request->get('title'),
            'question_number' => $request->get('question_number')
        ]);

        session()->flash('message', $test->title . " has been updated!");

        return redirect()->route('tests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test) {
        $this->authorize('delete', Test::class);
        $test->delete();

        if (request()->ajax()) {
            return response('done');
        }

        return redirect()->back();
    }
}
