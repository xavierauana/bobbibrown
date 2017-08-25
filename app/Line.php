<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Line extends Model
{

    protected $fillable = [
        'name',
        'category_id'
    ];

    // Relation

    public function products(): Relation {
        return $this->belongsToMany(Product::class);
    }

    public function category(): Relation {
        return $this->belongsTo(Category::class);
    }
}
