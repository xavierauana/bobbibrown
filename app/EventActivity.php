<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class EventActivity extends Model
{
    protected $fillable = [
        'ip',
        'type',
        'user_id',
        'event_id',
        'latitude',
        'token',
        'longitude',
    ];

    // Relation
    public function user(): Relation {
        return $this->belongsTo(User::class);
    }

    public function event(): Relation {
        return $this->belongsTo(Event::class);
    }
}
