<?php

namespace App;

use Anacreation\Etvtest\Contracts\TestableInterface;
use Anacreation\Etvtest\Contracts\TestableTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Lesson extends Model implements TestableInterface
{
    protected $fillable = [
        "permission_id",
        "title",
        "is_standalone",
        "body"
    ];

    use TestableTraits;

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
}
