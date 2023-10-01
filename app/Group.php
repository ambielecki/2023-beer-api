<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function locations(): HasMany {
        return $this->hasMany(Location::class);
    }

    public function getOptionsAttribute($value): array {
        return json_decode($value, true);
    }

    public function setOptionsAttribute($value): void {
        $this->attributes['options'] = json_encode($value);
    }
}
