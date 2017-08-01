<?php

namespace App;


class Test extends \Anacreation\Etvtest\Models\Test
{

    protected $fillable = [
        'title',
        'is_active',
        'order',
        'question_number'
    ];
}
