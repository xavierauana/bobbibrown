<?php

namespace App;

use Anacreation\Etvtest\Contracts\TestableTraits;
use App\Scopes\WithinPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Collection extends Model
{
    use WithinPermissions, TestableTraits;

    protected $fillable = [
        'title',
        'description',
        'permission_id',
        'poster',
        'is_featured',
        'is_new'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_new'      => 'boolean',
    ];

    public function lessons(): Relation {
        return $this->belongsToMany(Lesson::class)->withPivot('order');
    }

    public function permission(): Relation {
        return $this->belongsTo(Permission::class);
    }

    public function hasTest(): bool {
        return ($this->tests->count() or !!$this->lessons->first->hasTest());
    }

    // Mutators
    public function setDescriptionAttribute($value) {
        $this->attributes['description'] = trim($value);
    }

    // Helper functions
    public function isPassAllLessonsTest(User $user): bool {
        // if there is test, check the test is pass or not.
        // if there is no test, return true!
        return $this->lessons->every(function ($lesson) use ($user) {
            if ($test = $lesson->test) {
                return $user->passTest($test);
            }

            return true;
        });
    }

    public function isPassCollectionTests(User $user): bool {
        if ($this->tests()->count()) {
            return $this->tests->every(function ($test) use ($user) {
                return $user->passTest($test);
            });
        }

        return true;

    }
}
