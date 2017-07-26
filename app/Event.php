<?php

namespace App;

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
        'remind_days'
    ];

    protected $appends = [
        'currentVacancies'
    ];

    public function users(): Relation {
        return $this->belongsToMany(User::class);
    }

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

}
