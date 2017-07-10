<?php

namespace App;

use App\Events\UserSuccessfullyRegisterEvent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id'
    ];

    protected $casts = [
        'is_verified' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function verify(): void {
        $this->is_verified = true;
        $this->save();
    }

    public function events(): Relation {
        return $this->belongsToMany(Event::class);
    }

    public function register(Event $event): bool {
        if ($event->hasVacancy) {

            $event->users()->attach($this->id);

            event(new UserSuccessfullyRegisterEvent($this, $event));

            return true;
        }

        return false;

    }
}
