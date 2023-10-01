<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    protected $guarded = [];

    const APP_BEER = 'beer';
    const APPS = [
        self::APP_BEER,
    ];

    const PAGE_TYPE_HOME = 'home';
    const PAGE_TYPES = [
        self::PAGE_TYPE_HOME,
    ];
}
