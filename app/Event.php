<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

class Event extends Model
{
    protected $fillable = [
        'id',
        'title',
        'body',
        'vacancies',
        'start_datetime',
        'end_datetime',
        'publish_datetime',
        'permission_id',
        'remind_days',
        'venue',
        'photo',
    ];

    protected $appends = [
        'currentVacancies'
    ];


    public function getParticipantsAttribute(): Collection {
        return $this->users;
    }

    public function getHasVacancyAttribute(): bool {
        return $this->vacancies > $this->participants->count();
    }

    public function getCurrentVacanciesAttribute(): string {
        return ($this->vacancies - $this->participants->count()) . "/" . $this->vacancies;
    }

    public function removeUser(User $user) {
        $this->users()->detach($user->id);
    }

    // Relation

    public function users(): Relation {
        return $this->belongsToMany(User::class);
    }

    public function activities(): Relation {
        return $this->hasMany(EventActivity::class);
    }

    // scope

    public function scopeMatchUserPermissions($query, User $user): Builder {
        return $query->whereIn('permission_id',
            $user->permissions->pluck('id')->toArray());
    }

    public function scopeNotRegistered($query, User $user): Builder {
        return $query->whereNotIn("id",
            $user->events()->pluck('id')->toArray());
    }

}
