<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Product extends Model
{

    protected $fillable = [
        'name',
        'keywords',
        'permission_id',
        'content'
    ];

    // Relation
    public function lines(): Relation {
        return $this->belongsToMany(Line::class);
    }
}
