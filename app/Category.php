<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Category extends Model
{

    protected $fillable = [
        'name'
    ];

    // Relation

    public function lines(): Relation {
        return $this->hasMany(Line::class);
    }
}
