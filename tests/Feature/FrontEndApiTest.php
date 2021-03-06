<?php

namespace Tests\Feature;

use Anacreation\Etvtest\Services\GradingService;
use App\Collection;
use App\Event;
use App\Events\UserCancelEventRegistration;
use App\Events\UserSignInEvent;
use App\Events\UserSuccessfullyRegisterEvent;
use App\Lesson;
use App\Permission;
use App\Product;
use App\Role;
use App\Services\AttemptService;
use App\Setting;
use App\Test;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class FrontEndApiTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp() {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = factory(User::class)->create([
            "is_verified" => true,
            "is_approved" => true,
        ]);

        $this->actingAs($user);
    }

    public function test_home() {
        $response = $this->get(route("home"));
        $response->assertStatus(200);
    }

    public function test_progress() {
        $response = $this->get(route("progress"));
        $response->assertViewIs('progress');
        $ajaxResponse = $this->json("get", "progress");
        $ajaxResponse->assertJsonStructure(['collections', 'lessonsStatus']);
    }

    public function test_profile() {

        $response = $this->get(route("profile"));
        $response->assertStatus(200);
        $response->assertViewIs('profile');
        $response->assertViewHas(['user'], auth()->user());
    }

    public function test_post_profile() {
        $data = [
            'name'                  => '11111111',
            'email'                 => '11111111@abc.com',
            'password'              => "11111111",
            'password_confirmation' => "11111111"
        ];
        $response = $this->post(route("profile.update"), $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('message', 'Profile has been updated!');

        $this->assertDatabaseHas('users', [
            "id"    => auth()->user()->id,
            "name"  => $data['name'],
            "email" => $data['email'],
        ]);
    }

    public function test_show_collection_test() {

        $collection = factory(Collection::class)->create();

        $response = $this->get(route("show.collection.test", $collection->id));
        $response->assertStatus(302);

        $test = factory(Test::class)->create();
        $collection->tests()->save($test);

        $response = $this->get(route("show.collection.test", $collection->id));
        $response->assertViewIs('test');
        $response->assertViewHas('test');

        $response = $this->json("GET",
            route("show.collection.test", $collection->id));
        $response->assertJsonStructure(['test', 'questionTypes', 'previous']);
    }

    public function test_grade_collection_test_but_no_test() {
        $collection = factory(Collection::class)->create();
        $response = $this->post(route("grade.collection.test",
            $collection->id));
        $response->assertStatus(404);
    }

    public function test_grade_collection_test_without_data() {
        $collection = factory(Collection::class)->create();
        $test = factory(Test::class)->create();
        $collection->tests()->save($test);

        $response = $this->post(route("grade.collection.test",
            $collection->id));

        $response->assertStatus(404);
    }

    public function test_grade_collection_test_with_data() {
        $collection = factory(Collection::class)->create();
        $test = factory(Test::class)->create();
        $collection->tests()->save($test);

        $data = [
            'answers'     => [],
            'questionIds' => [],
        ];

        $serviceMock = $this->createMockClass(GradingService::class);
        $settingMock = $this->createMockClass(Setting::class);
        $attemptServiceMock = $this->createMockClass(AttemptService::class);

        $settingMock->shouldReceive("getAttribute")->andReturn(0.7);

        $serviceMock->shouldReceive("grade")->once();
        $serviceMock->result = [1, 2, 3, 4, 5, 6, 7];
        $serviceMock->summary = ['correct' => 2];

        $attemptServiceMock->shouldReceive("createUserAttemptRecord")->once();


        $response = $this->post(route("grade.collection.test",
            $collection->id), $data);

        $response->assertStatus(200);
    }

    public function test_lesson_test_but_no_test() {
        $lesson = factory(Lesson::class)->create();
        $response = $this->post(route("grade.lesson.test",
            $lesson->id));
        $response->assertStatus(404);
    }

    public function test_lesson_test_has_test_but_no_answer_and_questionIds() {
        $lesson = factory(Lesson::class)->create();
        $test = factory(Test::class)->create();
        $lesson->tests()->save($test);
        $response = $this->post(route("grade.lesson.test",
            $lesson->id));
        $response->assertStatus(404);
    }

    public function test_lesson_test_has_test_and_answer() {
        $lesson = factory(Lesson::class)->create();
        $test = factory(Test::class)->create();
        $lesson->tests()->save($test);
        $data = [
            'answers'     => [],
            'questionIds' => [],
        ];

        $serviceMock = $this->createMockClass(GradingService::class);
        $settingMock = $this->createMockClass(Setting::class);
        $attemptServiceMock = $this->createMockClass(AttemptService::class);

        $settingMock->shouldReceive("getAttribute")->andReturn(0.7);

        $serviceMock->shouldReceive("grade")->once();
        $serviceMock->result = [1, 2, 3, 4, 5, 6, 7];
        $serviceMock->summary = ['correct' => 2];

        $attemptServiceMock->shouldReceive("createUserAttemptRecord")->once();

        $response = $this->post(route("grade.lesson.test",
            $lesson->id), $data);
        $response->assertStatus(200);
    }

    public function test_user_show_collection_without_permission() {
        $permission = factory(Permission::class)->create();

        $collection = factory(Collection::class)->create([
            'permission_id' => $permission->id
        ]);

        $response = $this->get(route("show.collection", $collection->id));

        $response->assertStatus(302);

        $role = factory(Role::class)->create();

        $role->permissions()->save($permission);
    }

    public function test_user_show_collection_has_permission() {

        list($role, $collection) = $this->createCollectionWithPermission();

        auth()->user()->roles()->save($role);

        $newResponse = $this->get(route("show.collection", $collection->id));
        $newResponse->assertStatus(200);

        $newResponse->assertViewIs("collection");
        $newResponse->assertViewHas("collection");
    }

    public function test_show_collection_lessons_without_lesson_association() {
        list($role, $collection) = $this->createCollectionWithPermission();

        auth()->user()->roles()->save($role);

        $lesson = factory(Lesson::class)->create();

        $response = $this->get(route("show.collection.lesson", [
            $collection->id,
            $lesson->id
        ]));

        $response->assertStatus(404);
    }

    public function test_show_collection_lessons() {
        list($role, $collection, $permission) = $this->createCollectionWithPermission();

        auth()->user()->roles()->save($role);

        $lesson = factory(Lesson::class)->create([
            "permission_id" => $permission->id
        ]);

        $collection->lessons()->save($lesson);

        $response = $this->get(route("show.collection.lesson", [
            $collection->id,
            $lesson->id
        ]));

        $response->assertViewIs('lesson');
        $response->assertViewHas(['collection', 'lesson']);
    }

    public function test_show_lesson_without_permission() {
        $lesson = factory(Lesson::class)->create();
        $response = $this->get(route("show.lesson", $lesson->id));

        $response->assertRedirect();
    }

    public function test_show_lesson() {
        list($permission, $role) = $this->createPermissionAndRole();
        $lesson = factory(Lesson::class)->create([
            "permission_id" => $permission->id,
            "is_standalone" => true
        ]);
        auth()->user()->roles()->save($role);

        $response = $this->get(route("show.lesson", $lesson->id));

        $response->assertViewIs("lesson");
        $response->assertViewHas("lesson");
    }

    public function test_show_lesson_test_no_test() {
        list($permission, $role) = $this->createPermissionAndRole();
        $lesson = factory(Lesson::class)->create([
            "permission_id" => $permission->id,
            "is_standalone" => true
        ]);
        auth()->user()->roles()->save($role);

        $response = $this->get(route("show.lesson.test", $lesson->id));

        $response->assertRedirect();
    }

    public function test_show_lesson_test() {

        $test = factory(Test::class)->create();
        list($permission, $role) = $this->createPermissionAndRole();
        $lesson = factory(Lesson::class)->create([
            "permission_id" => $permission->id,
            "is_standalone" => true
        ]);
        $lesson->tests()->save($test);

        auth()->user()->roles()->save($role);

        $response = $this->get(route("show.lesson.test", $lesson->id));

        $response->assertViewIs("test");
        $response->assertViewHas("test");

        $jsonResponse = $this->json("GET",
            route("show.lesson.test", $lesson->id));
        $jsonResponse->assertJsonStructure([
            'test',
            'questionTypes',
            'previous',
        ]);
    }

    public function test_grade_lesson_test_with_no_association() {
        list($permission, $role) = $this->createPermissionAndRole();
        $lesson = factory(Lesson::class)->create([
            "permission_id" => $permission->id
        ]);

        auth()->user()->roles()->save($role);

        $response = $this->post(route("grade.lesson.test", $lesson->id));

        $response->assertStatus(404);
    }

    public function test_grade_lesson_test() {
        //TODO:: fix test with data
        list($permission, $role) = $this->createPermissionAndRole();

        $lesson = factory(Lesson::class)->create([
            "permission_id" => $permission->id
        ]);

        $lesson->tests()->save(factory(Test::class)->create());

        auth()->user()->roles()->save($role);

        $response = $this->post(route("grade.lesson.test", $lesson->id));

        $response->assertStatus(404);
    }

    public function test_show_resources() {
        $response = $this->get(route("show.resources"));

        $response->assertViewIs('resources');
        $response->assertViewHas('categories');
    }

    public function test_show_product_without_permission() {

        list($permission, $role) = $this->createPermissionAndRole();
        $product = factory(Product::class)->create([
            'permission_id' => $permission->id
        ]);

        $response = $this->get(route("show.product", $product->id));

        $response->assertRedirect(route('home'));
    }

    public function test_show_product() {

        list($permission, $role) = $this->createPermissionAndRole();
        $product = factory(Product::class)->create([
            'permission_id' => $permission->id
        ]);

        auth()->user()->roles()->save($role);

        $response = $this->get(route("show.product", $product->id));

        $response->assertViewIs("product");
        $response->assertViewHas("product");
    }

    public function test_show_events() {
        $this->get(route("show.events"))->assertViewIs('events')
             ->assertViewHas('events');
    }

    public function test_show_my_events() {
        $this->get(route("show.myevents"))->assertViewIs('my_events')
             ->assertViewHas('events');
    }

    public function test_user_cancel_event() {
        list($permission, $role) = $this->createPermissionAndRole();

        $event = $this->createEventWithPermission($permission);

        auth()->user()->roles()->save($role);

        $event->users()->save(auth()->user());

        $this->expectsEvents(UserCancelEventRegistration::class);

        $this->post(route("user.event.cancel", $event->id))
             ->assertJsonStructure(['user']);
    }

    public function test_user_cancel_event_without_registration() {
        list($permission, $role) = $this->createPermissionAndRole();

        $event = $this->createEventWithPermission($permission);

        auth()->user()->roles()->save($role);


        $this->post(route("user.event.cancel", $event->id))->assertStatus(501);
    }

    public function test_registration() {

        $this->expectsEvents(UserSuccessfullyRegisterEvent::class);

        list($permission, $role) = $this->createPermissionAndRole();

        $event = factory(Event::class)->create([
            'permission_id' => $permission->id,
            'vacancies'     => 10,
        ]);

        auth()->user()->roles()->save($role);

        $this->post(route("user.event.registration", $event->id))
             ->assertJsonFragment(['status' => "Completed"]);

    }

    public function test_registration_without_permission() {

        list($permission, $role) = $this->createPermissionAndRole();
        list($permission1, $role) = $this->createPermissionAndRole();

        $event = factory(Event::class)->create([
            'permission_id' => $permission1->id,
            'vacancies'     => 10,
        ]);

        $this->post(route("user.event.registration", $event->id))
             ->assertStatus(501);

    }

    public function test_registration_event_is_full() {

        list($permission, $role) = $this->createPermissionAndRole();

        $event = factory(Event::class)->create([
            'permission_id' => $permission->id,
            'vacancies'     => 0,
        ]);
        auth()->user()->roles()->save($role);

        $this->post(route("user.event.registration", $event->id))
             ->assertStatus(501);

    }

    public function test_event_singin() {

        $event = factory(Event::class)->create();

        $this->get(route("signin.event", $event->id) . "?token=somehting")
             ->assertViewIs("event_sign_in")->assertViewHas(['event', 'token']);

    }

    public function test_event_singin_without_token() {

        $event = factory(Event::class)->create();

        $this->get(route("signin.event", $event->id))->assertRedirect();

    }

    public function test_log_event_signin_without_registration() {
        list($permission, $role) = $this->createPermissionAndRole();

        $event = $this->createEventWithPermission($permission);

        $this->post(route("log.signin.event", $event->id))->assertStatus(501);
    }

    public function test_log_event_signin() {
        list($permission, $role) = $this->createPermissionAndRole();

        $event = $this->createEventWithPermission($permission);

        $event->users()->save(auth()->user());

        $this->expectsEvents(UserSignInEvent::class);

        $this->post(route("log.signin.event", $event->id))
             ->assertSeeText(Carbon::now()->toDateString());
    }

    public function tests_show_event_detail() {
        list($permission, $role) = $this->createPermissionAndRole();
        $event = $this->createEventWithPermission($permission);

        auth()->user()->roles()->save($role);

        $this->get(route("show.event.detail", $event->id))
             ->assertViewIs("event_detail")->assertViewHas('event');
    }

    public function tests_show_event_detail_without_permission() {
        list($permission, $role) = $this->createPermissionAndRole();
        $event = $this->createEventWithPermission($permission);

        $this->get(route("show.event.detail", $event->id))->assertRedirect();
    }

    #region helper methods
    private function createCollectionWithPermission() {

        list($permission, $role) = $this->createPermissionAndRole();

        $collection = factory(Collection::class)->create([
            'permission_id' => $permission->id
        ]);

        return [$role, $collection, $permission];
    }

    public function createPermissionAndRole(): array {
        $permission = factory(Permission::class)->create();
        $role = factory(Role::class)->create();
        $role->permissions()->save($permission);

        return [$permission, $role];
    }

    public function createEventWithPermission(Permission $permission): Event {
        return factory(Event::class)->create([
            'permission_id' => $permission->id
        ]);
    }

    /**
     * @param string $class
     * @return \Mockery\MockInterface
     */
    private function createMockClass(string $class): MockInterface {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    #endregion
}
