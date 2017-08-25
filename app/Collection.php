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

    public function menus(): Relation {
        return $this->morphMany(Menu::class, 'has_menu');
    }

    public function hasTest(): bool {
        return $this->tests->count() > 0;
    }

    // Mutators
    public function setDescriptionAttribute($value) {
        $this->attributes['description'] = trim($value);
    }
}
