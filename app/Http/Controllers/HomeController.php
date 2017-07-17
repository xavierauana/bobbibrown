<?php

namespace App\Http\Controllers;

use Anacreation\Etvtest\Converters\ConverterManager;
use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Etvtest\Services\GradingService;
use Anacreation\Etvtest\Services\QuestionTypeServices;
use App\Collection;
use App\Event;
use App\Lesson;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $collection->load([
            'lessons' => function ($query) {
                return $query->orderBy('pivot_order');
            }
        ]);

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

    public function showLessonTest(Request $request, Lesson $lesson) {

        if ($test = $lesson->tests->first()) {
            if (!$request->ajax()) {
                return view('test', compact('test'));
            }

            $testData = ConverterManager::convert($test)->getData();

            return response()->json([
                'test'          => $testData,
                'questionTypes' => (new QuestionTypeServices())->getQuestionTypes(),
                'previous'      => []
            ]);
        }


        return redirect()->back();
    }

    public function gradeTest(Request $request, Test $test, GradingService $service) {
        $service->grade($test, $request->all());
        $this->createUserAttemptRecord($test, $service, auth()->user());

        return response()->json([
            'result'    => $service->result,
            'summary'   => $service->summary,
            'is_passed' => ($service->summary["correct"] / count($service->result)) > (intval(Setting::whereCode('test_passing_rate')
                                                                                                     ->first()->value) / 100)
        ]);
    }

    public function showEvents() {
        $events = Event::where('start_datetime', '>', Carbon::now())->orderBy('start_datetime')->with('users')->get()
                       ->map(function (Event $event) {
                           return [
                               'id'           => $event->id,
                               'title'        => $event->title,
                               'can_register' => auth()->user()->canRegisterEvent($event),
                               'vacancies'    => $event->vacancies,
                               'participants' => $event->participants->count(),
                           ];
                       });

        return view('events', compact('events'));
    }

    public function showEventDetail(Event $event) {
        return view('event_detail', compact('event'));
    }

    public function registerEvent(Event $event) {
        if ($event->hasVacancy) {
            if (auth()->user()->registerEvent($event)) {
                return response()->json(['register' => true]);
            }
        }

        return response()->json(['register' => false, 'message' => 'The event id full!']);
    }

    /**
     * @param $testId
     * @param $user
     * @param $service
     */
    private function createUserAttemptRecord(Test $test, GradingService $service, User $user = null): Attempt {

        $attempt_data = [];

        if ($user) {
            $attempt_data = $this->createAttemptData($test, $service);

            return $user->attempts()->create($attempt_data);
        }

        return new Attempt($attempt_data);
    }

    /**
     * @param \Anacreation\Etvtest\Models\Test             $test
     * @param \Anacreation\Etvtest\Services\GradingService $service
     * @return array
     */
    private function createAttemptData(Test $test, GradingService $service): array {
        $attempt_data = [
            "test_id" => $test->id,
            "attempt" => $service->result,
            "score"   => $service->summary['correct'] / count($service->result),
        ];

        return $attempt_data;
    }
}