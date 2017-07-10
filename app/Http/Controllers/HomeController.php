<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Lesson;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $collections = Collection::all();
        $lessons = Lesson::whereIsStandalone(true)->get();

        return view('home', compact('collections', 'lessons'));
    }

    public function showCollection(Collection $collection) {
        $collection->load('lessons');

        return view('collection', compact('collection'));
    }

    public function showCollectionLesson(Collection $collection, $lessonId) {

        $lesson = $collection->lessons()->findOrFail($lessonId);

        return view('lesson', compact('collection', 'lesson'));
    }

    public function showLesson(Lesson $lesson) {

        if ($lesson->is_standalone) {
            return view('lesson', compact('lesson'));
        }

        return redirect()->back();
    }

    public function showLessonTest(Lesson $lesson) {

        if ($test = $lesson->tests->first()) {
            return view('test', compact('test', 'lesson'));
        }

        return redirect()->back();
    }
}
