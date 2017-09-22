<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'label',
        'value'
    ];

    public function getPassingRateAttribute(): float {
        return $this->whereCode('test_passing_rate')
                    ->first()->value / 100;
    }
}
