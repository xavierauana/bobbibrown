<?php

namespace App;

use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_approved' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    #region Accessors

    public function getAvailableLessonsAttribute(): Collection {

        $lesson = app(Lesson::class);
        // this user has permission
        $permission_ids = $this->permissions->pluck('id')->toArray();
        //        dd( $this->permissions);

        // this user can attempt test with its permission
        return $lesson->whereIn('permission_id', $permission_ids)->get();

    }

    public function getCollectionsAttribute(): Collection {
        // this user has permission
        $permission_ids = $this->permissions->pluck('id')->toArray();

        // this user can attempt test with its permission
        return \App\Collection::whereIn('permission_id', $permission_ids)
                              ->with([
                                  'lessons' => function ($query) use (
                                      $permission_ids
                                  ) {
                                      return $query->orderBy('order')
                                                   ->wherePermissionId($permission_ids)
                                                   ->with('tests');
                                  },
                                  "tests"
                              ])->get();

    }

    public function getPermissionsAttribute(): Collection {
        return $this->roles->map(function (Role $role) {
            return $role->permissions;
        })->flatten()->unique('id')->values();
    }

    public function getIsActiveAttribute(): bool {
        return $this->is_verified and $this->is_approved;
    }
    #endregion

    #region Relation

    public function events(): Relation {
        return $this->belongsToMany(Event::class);
    }

    public function attempts(): Relation {
        return $this->hasMany(Attempt::class);
    }

    public function roles(): Relation {
        return $this->belongsToMany(Role::class);
    }

    public function eventActivities(): Relation {
        return $this->hasMany(EventActivity::class);
    }
    #endregion

    #region Scope
    public function scopeIsActive($query) {
        return $query->where([
            'is_verified' => true,
            'is_approved' => true,
        ]);
    }

    #endregion

    #region Public Methods
    public function verify(): void {
        $this->is_verified = true;
        $this->save();
    }

    public function register(Event $event): bool {
        if ($event->hasVacancy) {

            $event->users()->attach($this->id);

            return true;
        }

        return false;

    }

    public function cancel(Event $event): bool {

        if ($this->events()->whereId($event->id)->count()) {
            $event->users()->detach($this->id);

            return true;
        }

        return false;

    }

    public function signin(Event $event): bool {

        if ($this->events()->whereId($event->id)->count()) {

            return true;
        }

        return false;

    }

    public function logEventActivity($type, Event $event, Request $request) {
        $this->eventActivities()->create([
            'type'     => $type,
            'event_id' => $event->id,
            'ip'       => $request->ip()
        ]);
    }

    public function passCollection(\App\Collection $collection = null): bool {

        if ($collection) {

            $collection->load('lessons.tests');

            if (!$collection->isPassAllLessonsTest($this)) {
                return false;
            }

            return $collection->isPassCollectionTests($this);
        }

        return false;
    }

    public function passTest(Test $test = null): bool {
        if ($test) {
            $attempt = $this->attempts()->whereNotNull('score')
                            ->whereTestId($test->id)->latest()->first();
            if ($attempt) {
                $passingRate = doubleval(intval(Setting::whereCode('test_passing_rate')
                                                       ->first()->value) / 100);

                return $attempt->score > $passingRate;
            }
        }

        return false;
    }

    public function registerEvent(Event $event): bool {
        if (!$this->canRegisterEvent($event)) {

            return false;
        }

        $this->events()->attach($event->id);

        return true;
    }

    public function canRegisterEvent(Event $event): bool {
        if ($event->hasVacancy and $this->hasEventPermission($event)) {
            return $event->users()->where('user_id', $this->id)
                         ->first() ? false : true;
        }

        return false;
    }

    public function hasLessonPermission(Lesson $lesson): bool {
        return $this->hasObjectCollection($lesson);
    }

    public function hasEventPermission(Event $event): bool {
        return $this->hasPermission($event->permission->code);
    }

    public function hasCollectionPermission(\App\Collection $collection): bool {
        return $this->hasObjectCollection($collection);
    }

    public function latestPassedAttempts(Test $test): Collection {
        $passingRate = doubleval(intval(Setting::whereCode('test_passing_rate')
                                               ->first()->value) / 100);

        return $this->attempts()->whereTestId($test->id)->whereNotNull('score')
                    ->where('score', ">", $passingRate)->get();
    }

    public function matchEventPermission(Event $event): bool {
        return $this->hasPermission($event->permission->code);
    }

    public function showEventSingInTimestamp(Event $event) {
        $record = $this->getEventSingInRecord($event);

        return $record ? $record->created_at : null;
    }

    public function getGoogleMapUrlForSingIn(Event $event): ?string {
        $record = $this->getEventSingInRecord($event);
        if ($record and $record->longitude and $record->latitude) {
            return "http://maps.google.com/maps?q=loc:{$record->longitude},{$record->latitude}&z=17";
        }

        return null;
    }

    public function getEventSingInRecord(Event $event): ?EventActivity {
        return $this->eventActivities()->whereEventId($event->id)
                    ->whereType("singin")->latest()->first();
    }

    #endregion

    private function hasObjectCollection(Model $model): bool {
        return in_array($model->permission_id,
            $this->permissions->pluck('id')->toArray());
    }

    public function hasPermission($permissionCode): bool {
        $permissionCode = is_array($permissionCode) ? $permissionCode : [$permissionCode];
        $userPermissionCodes = $this->permissions->pluck('code')->toArray();

        return count(array_intersect($permissionCode,
                $userPermissionCodes)) > 0;
    }
}
