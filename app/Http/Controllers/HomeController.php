<?php

namespace App\Http\Controllers;

use Anacreation\Etvtest\Converters\ConverterManager;
use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Etvtest\Services\GradingService;
use Anacreation\Etvtest\Services\QuestionTypeServices;
use App\Collection;
use App\Event;
use App\Events\UserCancelEventRegistration;
use App\Events\UserSignInEvent;
use App\Events\UserSuccessfullyRegisterEvent;
use App\Http\Requests\EventRegistrationRequest;
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

            $this->randomPickTestQuestions($testData, $test->question_number);

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
            $service->grade($test, $request->get('answers'), $request->get('questionIds'));
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

    public function registration(EventRegistrationRequest $request, Event $event) {

        if (auth()->user()->register($event)) {
            event(new UserSuccessfullyRegisterEvent(auth()->user(), $event, $request));

            return response()->json(['status' => 'Completed', 'user' => $request->user()]);
        }

        return response("Cannot register!", 501);

    }

    public function cancelEvent(Request $request, Event $event) {


        if ($request->user()->cancel($event)) {
            event(new UserCancelEventRegistration($request->user(), $event, $request));

            return response()->json(["user" => $request->user()]);
        }

        return response('cannot cancel registration', 501);

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

    public function eventSignIn(Request $request, Event $event) {
        $token = $request->get('token');

        return view('event_sign_in', compact("event", "token"));
    }

    public function logSignIn(Request $request, Event $event) {

        if ($request->user()->signin($event)) {

            event(new UserSignInEvent($request->user(), $event, $request));

            return response(\Carbon\Carbon::now()->toDateTimeString());
        }

        return response("Sorry! You cannot sign in the event!", 501);
    }

    public function showMyEvents() {
        $events = auth()->user()->events()->orderBy('start_datetime')->get();

        return view('my_events', compact('events'));
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

    private function randomPickTestQuestions(array &$testData, int $question_number) {

        if ($question_number and $question_number < count($testData['questions'])) {

            $array_keys = array_rand($testData['questions'], $question_number);

            if (is_array($array_keys)) {
                $questions = [];
                foreach ($array_keys as $key) {
                    $questions[] = $testData['questions'][$key];
                }

                $testData['questions'] = $questions;
            } else {
                $testData['questions'] = [$testData['questions'][$array_keys]];
            }

        }

    }

}
