<?php

namespace App\Http\Controllers;

use Anacreation\Etvtest\Converters\ConverterManager;
use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Etvtest\Services\GradingService;
use Anacreation\Etvtest\Services\QuestionTypeServices;
use App\Collection;
use App\Event;
use App\Http\Requests\Users\UpdateProfileRequest;
use App\Lesson;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $eventTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');

        $this->eventTransformer = function (Event $event) {
            return [
                'id'           => $event->id,
                'photo'        => $event->photo,
                'venue'        => $event->venue,
                'title'        => $event->title,
                'startDate'    => $event->start_datetime,
                'can_register' => auth()->user()->canRegisterEvent($event),
                'vacancies'    => $event->vacancies,
                'participants' => $event->participants->count(),
            ];
        };
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $collections = Collection::available(auth()->user())->get();
        $lessons = Lesson::whereIsStandalone(true)->available(auth()->user())->get();

        return view('home', compact('collections', 'lessons'));
    }

    public function showCollection(Collection $collection) {

        if (auth()->user()->hasCollectionPermission($collection)) {
            $collection->load([
                'lessons' => function ($query) {
                    return $query->orderBy('pivot_order')->available(auth()->user());
                }
            ]);

            return view('collection', compact('collection'));
        }

        session()->flash('message', 'You are not allow to accessing this series!');

        return redirect()->back();

    }

    public function showCollectionLesson(Collection $collection, $lessonId) {

        $lesson = $collection->lessons()->available(auth()->user())->findOrFail($lessonId);

        return view('lesson', compact('collection', 'lesson'));
    }

    public function showLesson(Lesson $lesson) {

        if ($lesson->is_standalone and auth()->user()->hasLessonPermission($lesson)) {
            return view('lesson', compact('lesson'));
        }

        session()->flash('message', 'You are not allow to accessing this lesson!');

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

    public function gradeTest(Request $request, Lesson $lesson, GradingService $service) {
        if ($test = $lesson->test) {
            $service->grade($test, $request->all());
            $this->createUserAttemptRecord($test, $service, auth()->user());

            return response()->json([
                'result'    => $service->result,
                'summary'   => $service->summary,
                'is_passed' => ($service->summary["correct"] / count($service->result)) > (intval(Setting::whereCode('test_passing_rate')
                                                                                                         ->first()->value) / 100)
            ]);
        }

        return response('No test!', 404);
    }

    public function showEvents() {
        $events = Event::where('start_datetime', '>', Carbon::now())->orderBy('start_datetime')->with('users')->get()
                       ->map($this->eventTransformer);

        return view('events', compact('events'));
    }

    public function showEventDetail(Event $event) {
        $event->body = nl2br($event->body);

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

    public function getProfile() {
        return view('profile', ['user' => auth()->user()]);
    }

    public function postProfile(UpdateProfileRequest $request) {
        $user = auth()->user();

        $data = [
            'name'  => $request->get('name'),
            'email' => $request->get('email'),
        ];
        if ($request->get('password')) {
            $data['password'] = $request->get('password');
        }

        $user->update($data);

        session()->flash('message', 'Profile has been updated!');

        return redirect()->route('home');
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
