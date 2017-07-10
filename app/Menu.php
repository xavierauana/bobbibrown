<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Menu extends Model
{
    protected $fillable = [
        'has_menu_type',
        'has_menu_id',
        'title',
        'url',
        'is_active',
    ];

    public function hasMenu(): Relation {
        return $this->morphTo();
    }

    public function setUrlAttribute($value) {
        $this->attributes['url'] = urlencode($value);
    }
}
