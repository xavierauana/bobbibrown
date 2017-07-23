<?php

namespace App;

use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use App\Events\UserSuccessfullyRegisterEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
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

    public function verify(): void {
        $this->is_verified = true;
        $this->save();
    }

    public function register(Event $event): bool {
        if ($event->hasVacancy) {

            $event->users()->attach($this->id);

            event(new UserSuccessfullyRegisterEvent($this, $event));

            return true;
        }

        return false;

    }

    // Accessors

    public function getAvailableLessonsAttribute(): Collection {
        // this user has permission
        $permission_ids = $this->permissions->pluck('id')->toArray();
        //        dd( $this->permissions);

        // this user can attempt test with its permission
        return Lesson::whereIn('permission_id', $permission_ids)->get();

    }

    public function getPermissionsAttribute(): Collection {
        return $this->roles->map(function (Role $role) {
            return $role->permissions;
        })->flatten()->unique('id')->values();
    }

    public function getIsActiveAttribute(): bool {
        return $this->is_verified and $this->is_approved;
    }

    // Relation

    public function events(): Relation {
        return $this->belongsToMany(Event::class);
    }

    public function attempts(): Relation {
        return $this->hasMany(Attempt::class);
    }

    public function roles(): Relation {
        return $this->belongsToMany(Role::class);
    }

    // Methods
    public function passCollection(\App\Collection $collection = null): bool {

        if ($collection) {

            $collection->load([
                'lessons' => function ($query) {
                    return $query->with('tests');
                }
            ]);

            foreach ($collection->lessons as $lesson) {
                if ($lesson->test and !$this->passTest($lesson->test)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function passTest(Test $test = null): bool {
        if ($test) {
            $attempt = Attempt::whereNotNull('score')->whereTestId($test->id)->whereUserId($this->id)->first();
            if ($attempt) {
                $passingRate = intval(Setting::whereCode('test_passing_rate')->first()->value) / 100;

                return $attempt->score > $passingRate;
            }
        }

        return false;
    }

    public function registerEvent(Event $event): bool {
        if ($event->hasVacancy) {
            $this->events()->attach($event->id);

            return true;
        }

        return false;
    }

    public function canRegisterEvent(Event $event): bool {
        if ($event->hasVacancy) {
            return $event->users()->where('user_id', $this->id)->first() ? false : true;
        }

        return false;
    }

    public function hasLessonPermission(Lesson $lesson): bool {
        return $this->hasObjectCollection($lesson);
    }

    public function hasCollectionPermission(\App\Collection $collection): bool {
        return $this->hasObjectCollection($collection);
    }

    private function hasObjectCollection(Model $model): bool {
        return in_array($model->permission_id, $this->permissions->pluck('id')->toArray());
    }

}
