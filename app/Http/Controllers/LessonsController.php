<?php

namespace App\Http\Controllers;

use Anacreation\Etvtest\Models\Test;
use App\Http\Requests\Lessons\CreateLessonRequest;
use App\Http\Requests\Lessons\EditLessonRequest;
use App\Http\Requests\Lessons\ShowLessonRequest;
use App\Http\Requests\Lessons\StoreLessonRequest;
use App\Http\Requests\Lessons\UpdateLessonRequest;
use App\Jobs\SendLessonReminder;
use App\Lesson;
use App\Permission;
use App\Services\SaveFormMedia;
use App\User;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->authorize('view', Lesson::class);
        if ($request->wantsJson()) {
            $lessons = Lesson::excludeColumns("body")->get();

            return response()->json($lessons);
        }


        return view('lessons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Lesson::class);
        $permissions = Permission::all();

        return view('lessons.create', compact('lessons', "permissions"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request) {

        //        dd($request->all());
        $newLesson = Lesson::create($this->parseFormData($request));

        $scheduleData = $request->get('schedule');

        $newLesson->schedule()->create([
            'days'    => $scheduleData["days"],
            'compare' => $scheduleData["compare"],
        ]);

        return redirect()->route('lessons.index');
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
    public function edit(Lesson $lesson) {

        $this->authorize('edit', Lesson::class);
        $permissions = Permission::all();

        return view('lessons.edit', compact('lesson', "permissions"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson) {

        //        dd($request->all());
        $lesson->update($this->parseFormData($request));
        $scheduleData = $request->get('schedule');
        $lesson->schedule->update([
            'days'    => $scheduleData["days"],
            'compare' => $scheduleData["compare"],
        ]);

        return redirect()->route('lessons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson) {

        $this->authorize('delete', Lesson::class);

        $lesson->delete();

        return response(200);
    }

    public function editTests(Lesson $lesson) {

        $this->authorize('edit', Lesson::class);

        $tests = Test::whereIsActive(true)->get();

        return view('lessons.edit_test',
            compact('tests', 'lesson', "permissions"));
    }

    public function updateTests(Lesson $lesson) {

        $this->authorize('edit', Lesson::class);

        $this->validate(request(), [
            'test_id' => 'required|in:' . implode(",",
                    Test::pluck("id")->toArray())
        ]);

        $lesson->tests()->sync(request()->get("test_id"));

        return redirect()->route('lessons.index');

    }

    public function getUsersForTest(Lesson $lesson) {

        $users = User::all();

        if ($test = $lesson->test) {

            return view('tests.users', compact("users", "test", "lesson"));
        }

        return view('tests.users', compact("users", "lesson"));

    }

    public function getUserTestRecords(Lesson $lesson, User $user) {

        $test = $lesson->tests()->first();
        $attempts = $user->attempts()->latest()->whereTestId($test->id)->get();

        return view('tests.user_records', compact('user', 'test', 'attempts'));
    }

    public function sendLessonReminder(Lesson $lesson, User $user) {
        $job = new SendLessonReminder($lesson, $user);
        $this->dispatch($job);

        return response('queued!');
    }

    private function parseFormData(Request $request) {
        $data = [
            'body'          => $request->get('body'),
            'title'         => $request->get('title'),
            'is_new'        => $request->get('is_new') ?: false,
            'is_featured'   => $request->get('is_featured') ?: false,
            'is_standalone' => $request->get('is_standalone'),
            'permission_id' => $request->get('permission_id'),
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
