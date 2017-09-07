<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests\Collections\CreateCollectionRequest;
use App\Http\Requests\Collections\EditCollectionRequest;
use App\Http\Requests\Collections\ShowCollectionRequest;
use App\Http\Requests\Collections\StoreCollectionRequest;
use App\Http\Requests\Collections\UpdateCollectionRequest;
use App\Http\Requests\Permissions\DeletePermissionRequest;
use App\Lesson;
use App\Permission;
use App\Services\SaveFormMedia;
use App\Test;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Collection::class);

        $collections = Collection::all();

        return view('collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Collection::class);

        $permissions = Permission::select('label', 'id')->get();

        return view('collections.create',
            compact('collections', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectionRequest $request) {
        $data = $this->parseFormData($request);

        Collection::create($data);

        return redirect()->route('collections.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Collection $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection) {
        $this->authorize('show', Collection::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Collection $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection) {

        $this->authorize('edit', Collection::class);

        $permissions = Permission::select('label', 'id')->get();

        return view('collections.edit', compact('collection', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Collection          $collection
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateCollectionRequest $request, Collection $collection
    ) {

        $data = $this->parseFormData($request);

        $collection->update($data);

        return redirect()->route('collections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Collection $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection) {
        $this->authorize('delete', Collection::class);

        $collection->delete();

        return response(200);
    }

    public function editLessonsIndex(Collection $collection) {
        $this->authorize('edit', Collection::class);

        $lessons = $collection->lessons()->select([
            'id',
            'title',
        ])->orderBy('pivot_order')->get();

        return view('collections.edit_lessons_index',
            compact('lessons', 'collection'));
    }

    public function editLessons(Collection $collection) {
        $this->authorize('edit', Collection::class);

        $lessons = Lesson::select(["id", 'title'])->get();

        return "done";

        return view('collections.edit_lessons',
            compact('lessons', 'collection'));
    }

    public function updateLessons(Collection $collection) {
        $this->authorize('edit', Collection::class);

        $ids = [];
        foreach (request()->all() as $lesson) {
            $ids[] = $lesson['id'];
        }
        $collection->lessons()->sync($ids);

        return response(200);
    }

    public function updateLessonsOrder(Collection $collection) {
        $this->authorize('edit', Collection::class);

        foreach (request()->all() as $lesson) {
            $collection->lessons()->updateExistingPivot($lesson['id'],
                ['order' => $lesson['pivot']['order']]);
        }
    }

    public function editTests(Collection $collection) {

        $this->authorize('edit', Collection::class);

        $tests = Test::whereIsActive(true)->get();

        return view('collections.edit_test', compact('tests', 'collection'));
    }

    public function updateTests(Collection $collection) {

        $this->authorize('edit', Collection::class);

        $this->validate(request(), [
            'test_id' => 'required|in:' . implode(",",
                    Test::pluck("id")->toArray())
        ]);

        $collection->tests()->sync(request()->get("test_id"));

        return redirect()->route('collections.index');

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function parseFormData(Request $request): array {
        $data = [
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'permission_id' => $request->get('permission_id'),
            'is_featured'   => $request->get('is_featured') ?: false,
            'is_new'        => $request->get('is_new') ?: false,
        ];
        if ($request->has('remove_poster')) {
            if ($request->get('remove_poster')) {
                $data['poster'] = null;
            }
        }
        if ($mediaRecord = SaveFormMedia::save($request, 'poster')) {
            $data['poster'] = $mediaRecord->link;
        }

        return $data;
    }
}
