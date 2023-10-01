<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    public function group(): BelongsTo {
        return $this->belongsTo(Group::class);
    }

    public function location(): BelongsTo {
        return $this->belongsTo(Location::class);
    }
}
