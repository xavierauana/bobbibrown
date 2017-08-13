<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailActivity extends Model
{
    protected $fillable = [
        'recipient',
        'mailable'
    ];
}
