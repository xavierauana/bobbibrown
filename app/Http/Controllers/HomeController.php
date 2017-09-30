<?php

namespace App\Http\Controllers;

use Anacreation\Etvtest\Contracts\TestableInterface;
use Anacreation\Etvtest\Converters\ConverterManager;
use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Etvtest\Services\GradingService;
use Anacreation\Etvtest\Services\QuestionTypeServices;
use App\Category;
use App\Collection;
use App\Event;
use App\Events\UserCancelEventRegistration;
use App\Events\UserSignInEvent;
use App\Events\UserSuccessfullyRegisterEvent;
use App\Http\Requests\EventRegistrationRequest;
use App\Http\Requests\Users\UpdateProfileRequest;
use App\Lesson;
use App\Product;
use App\Services\AttemptService;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $collections = Collection::available(auth()->user())->latest()->get();
        $lessons = Lesson::whereIsStandalone(true)->available(auth()->user())
                         ->latest()->get();
        $featured = $this->createFeaturedItems($collections, $lessons);

        $new = $this->getNewThings($collections, $lessons);

        return view('home',
            compact('collections', 'lessons', 'featured', 'new'));
    }

    public function showCollection(Collection $collection) {

        if (auth()->user()->hasCollectionPermission($collection)) {
            $collection->load([
                'lessons' => function ($query) {
                    return $query->orderBy('pivot_order')
                                 ->available(auth()->user());
                }
            ]);

            return view('collection', compact('collection'));
        }

        session()->flash('message',
            'You are not allow to accessing this series!');

        return redirect()->back();

    }

    public function showCollectionLesson(Collection $collection, $lessonId) {

        $lesson = $collection->lessons()->available(auth()->user())
                             ->find($lessonId);

        return $lesson ? view('lesson',
            compact('collection', 'lesson')) : response("No lesson found!",
            404);
    }

    public function showLesson(Lesson $lesson) {

        if ($lesson->is_standalone and auth()->user()
                                             ->hasLessonPermission($lesson)) {
            return view('lesson', compact('lesson'));
        }

        session()->flash('message',
            'You are not allow to accessing this lesson!');

        return redirect()->back();
    }

    public function showLessonTest(Request $request, Lesson $lesson) {

        if ($test = $lesson->tests->first()) {
            if (!$request->wantsJson()) {
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

    public function showCollectionTest(Request $request, Collection $collection
    ) {
        if ($test = $collection->tests->first()) {
            if (!$request->wantsJson()) {
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

    public function gradeLessonTest(
        Request $request, Lesson $lesson, GradingService $service,
        AttemptService $attemptService, Setting $setting
    ) {
        /** @var Test $test */
        if ($test = $this->hasTestAndProperInput($request, $lesson)) {

            $service->grade($test, $request->get('answers'),
                $request->get('questionIds'));
            $attemptService->createUserAttemptRecord($test, $service,
                auth()->user());

            return response()->json([
                'result'    => $service->result,
                'summary'   => $service->summary,
                'is_passed' => ($service->summary["correct"] / count($service->result)) > $setting->passingRate
            ]);
        }

        return response('No test!', 404);
    }

    public function gradeCollectionTest(
        Request $request, Collection $collection, GradingService $service,
        AttemptService $attemptService,
        Setting $setting
    ) {
        if ($test = $this->hasTestAndProperInput($request, $collection)) {

            $service->grade($test, $request->get('answers'),
                $request->get('questionIds'));
            $attemptService->createUserAttemptRecord($test, $service,
                auth()->user());

            return response()->json([
                'result'    => $service->result,
                'summary'   => $service->summary,
                'is_passed' => ($service->summary["correct"] / count($service->result)) > $setting->passingRate
            ]);
        }

        return response('No test!', 404);
    }

    public function showEvents() {
        $events = Event::getActiveEventsForUser(auth()->user())->get()
                       ->map($this->eventTransformer);

        return view('events', compact('events'));
    }

    public function showEventDetail(Event $event) {

        if (auth()->user()->matchEventPermission($event)) {
            $event->body = nl2br($event->body);

            return view('event_detail', compact('event'));
        }

        return redirect()->back();
    }

    public function registration(EventRegistrationRequest $request, Event $event
    ) {
        if (auth()->user()->registerEvent($event)) {
            event(new UserSuccessfullyRegisterEvent(auth()->user(), $event,
                $request));

            return response()->json([
                'status' => 'Completed',
                'user'   => $request->user()
            ]);
        }

        return response("Cannot register!", 501);

    }

    public function cancelEvent(Request $request, Event $event) {

        if ($request->user()->cancel($event)) {
            event(new UserCancelEventRegistration($request->user(), $event,
                $request));

            return response()->json(["user" => $request->user()]);
        }

        return response('cannot cancel registration', 501);

    }

    public function getProfile() {
        return view('profile', ['user' => auth()->user()]);
    }

    public function postProfile(UpdateProfileRequest $request) {
        Log::info('post profile');
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
        $this->validate($request, [
            'token' => "required"
        ]);
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

    public function showResources() {

        $categories = Category::with([
            'lines' => function ($query) {
                return $query->with([
                    'products' => function ($query) {
                        return $query->permittedProducts(auth()->user())
                                     ->select([
                                         'id',
                                         'name',
                                         'keywords',
                                         'permission_id'
                                     ]);
                    }
                ]);
            }
        ])->get();

        return view('resources', compact("categories"));
    }

    public function showProduct(Product $product) {

        if (in_array($product->permission_id,
            auth()->user()->permissions->pluck('id')->toArray())) {
            return view('product', compact("product"));
        }

        return redirect()->route('home');
    }

    public function getProgress(Request $request) {

        if ($request->wantsJson()) {
            $collections = auth()->user()->collections;
            $lessonsStatus = new \Illuminate\Support\Collection();
            $collections->each(function (\App\Collection $collection) use (
                &$lessonsStatus
            ) {
                $collection->lessons->each(function (Lesson $lesson) use (
                    &$lessonsStatus
                ) {
                    if ($test = $lesson->test) {
                        $lessonsStatus->put($test->id, [
                            'is_overdue'   => $lesson->isOverDue(auth()->user()),
                            'due_in_days'  => $lesson->dueInDays(auth()->user()),
                            'is_completed' => auth()->user()->passTest($test),
                        ]);
                    }
                });
            });

            return response()->json(compact('collections', 'lessonsStatus'));

        }


        return view("progress");
    }

    #region Private methods

    /**
     * @param $testId
     * @param $user
     * @param $service
     */
    private function createUserAttemptRecord(
        Test $test, GradingService $service, User $user = null,
        AttemptService $attemptService
    ): Attempt {

        $attempt_data = [];

        if ($user) {
            $attempt_data = $attemptService->createAttemptData($service, $test);

            return $user->attempts()->create($attempt_data);
        }

        return new Attempt($attempt_data);
    }

    /**
     * @param \Anacreation\Etvtest\Models\Test             $test
     * @param \Anacreation\Etvtest\Services\GradingService $service
     * @return array
     */
    //    private function createAttemptData(Test $test, GradingService $service
    //    ): array {
    //        $attempt_data = [
    //            "test_id" => $test->id,
    //            "attempt" => $service->result,
    //            "score"   => $service->summary['correct'] / count($service->result),
    //        ];
    //
    //        return $attempt_data;
    //    }

    private function randomPickTestQuestions(
        array &$testData, int $question_number
    ) {

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

    /**
     * @param $collections
     * @param $lessons
     * @return mixed
     */
    protected function getNewThings($collections, $lessons) {
        $new_collections = $collections->filter(function ($collection) {
            if ($collection->is_new) {
                return $collection;
            }
        });
        $new_lessons = $lessons->filter(function ($lesson) {
            if ($lesson->is_new == true) {
                return $lesson;
            }
        });

        $user = auth()->user();
        $newEvents = Event::matchUserPermissions($user)->latest()
                          ->where("start_datetime", ">", Carbon::now())
                          ->notRegistered($user)->get();
        $new = $new_collections->merge($new_lessons);
        $new = $new->merge($newEvents);

        $new = $new->sortByDesc(function (Model $model) {
            return $model->created_at;
        });

        return $new;
    }

    /**
     * @param $collections
     * @param $lessons
     * @return mixed
     */
    protected function createFeaturedItems($collections, $lessons) {
        $featured_collections = $collections->filter(function ($collection) {
            if ($collection->is_featured) {
                return $collection;
            }
        });
        $featured_lessons = $lessons->filter(function ($lesson) {
            if ($lesson->is_featured) {
                return $lesson;
            }
        });
        $featured = $featured_collections->merge($featured_lessons);

        return $featured;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Lesson              $lesson
     * @return bool
     */
    private function hasTestAndProperInput(
        Request $request, TestableInterface $testable
    ): ?Test {
        if ($test = $testable->tests()
                             ->first() and $request->has('answers') and $request->has('questionIds')) {
            return $test;
        };

        return null;
    }

    #endregion
}
