<?php

namespace App;

use Anacreation\Etvtest\Contracts\TestableInterface;
use Anacreation\Etvtest\Contracts\TestableTraits;
use Anacreation\Etvtest\Models\Test;
use App\Scopes\WithinPermissions;
use App\Services\LessonDeadlineCalculator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;

class Lesson extends Model implements TestableInterface
{
    use WithinPermissions, TestableTraits;

    protected $fillable = [
        "body",
        "title",
        'is_new',
        "poster",
        'is_featured',
        "is_standalone",
        "permission_id",
    ];


    protected $casts = [
        'is_featured' => 'boolean',
        'is_new'      => 'boolean',
    ];

    public function collections(): Relation {
        return $this->belongsToMany(Collection::class)->withPivot('order');
    }

    public function permission(): Relation {
        return $this->belongsTo(Permission::class);
    }

    public function menus(): Relation {
        return $this->morphMany(Menu::class, 'has_menu');
    }

    public function hasTest(): bool {
        return $this->tests->count() > 0;
    }

    public function getTestAttribute(): ?Test {
        return $this->tests()->first();
    }

    public function schedule(): Relation {
        return $this->hasOne(LessonSchedule::class);
    }

    public function isOverDue(User $user): bool {

        $service = new LessonDeadlineCalculator($this);

        return $service->isOverDue($user);
    }

    public function dueInDays(User $user): int {

        $service = new LessonDeadlineCalculator($this);

        return $service->dueInDate($user);
    }

    // scope

    public function scopeExcludeColumns($query, $columns): Builder {
        $columns = is_array($columns) ? $columns : [$columns];
        return $query->select(array_diff($this->getAllTableColumns(),
            $columns));
    }

    // Helper Functions

    private function getAllTableColumns(): array {
        return Schema::getColumnListing("lessons");
    }

}
