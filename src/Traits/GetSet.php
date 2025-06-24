<?php

namespace App\Traits;

use App\Http\Resources\Backend\SetSectionResource;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait GetSet
{

    function meta(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? json_decode($value) : null,
            set: fn($value) => $value ? json_encode($value) : null
        );
    }

    function galleries(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? json_decode($value) : null,
            set: fn($value) => $value ? json_encode($value) : null
        );
    }

    function image(): Attribute
    {
        return Attribute::make(
            get: fn() => getImage($this->image),
            set: fn($value) => $value ? json_encode($value) : null,
        );
    }

    function tools(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? json_decode($value) : null,
            set: fn($value) => $value ? json_encode($value) : null,
        );
    }

    function credits(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? json_decode($value) : null,
            set: fn($value) => $value ? json_encode($value) : null,
        );
    }

    function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d H:i') : null,
            set: fn($value) => $value ? Carbon::parse($value) : null
        );
    }

    function startedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null,
            set: fn($value) => $value ? Carbon::parse($value) : null
        );
    }

    function endedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null,
            set: fn($value) => $value ? Carbon::parse($value) : null
        );
    }
}
