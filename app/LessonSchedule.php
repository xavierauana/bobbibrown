<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class LessonSchedule extends Model
{
    protected $fillable = [
        'days',
        'compare',
        'lesson_id'
    ];

    // Relation
    public function lesson(): Relation {
        return $this->belongsTo(Lesson::class);
    }
}
