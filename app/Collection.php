<?php

namespace App;

use App\Scopes\WithinPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Collection extends Model
{
    use WithinPermissions;

    protected $fillable = [
        'title',
        'description',
        'permission_id'
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


    // Mutators
    public function setDescriptionAttribute($value) {
        $this->attributes['description'] = trim($value);
    }
}
