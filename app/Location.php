<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
{
    protected $fillable = [
        'group_id',
        'name',
        'description',
        'address',
        'link',
    ];

    public function events(): HasMany {
        return $this->hasMany(Event::class);
    }

    public function group(): BelongsTo {
        return $this->belongsTo(Group::class);
    }
}
