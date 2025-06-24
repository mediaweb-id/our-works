<?php

namespace MediaWebId\OurWorks\Models;

use App\Traits\GetSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class OurWorks extends Model {

    use GetSet;

    protected $table = "ourworks";
    protected $casts = [
        'deleted_at' => 'datetime',
        'published_at' => 'datetime',
        'galleries' => 'array',
        'tools' => 'array',
        'credits' => 'array',
        'meta' => 'array',
        'image' => 'array',

    ];

    protected $fillable = [
        'title',
        'slug',
        'descriptions',
        'summary',
        'image',
        'audio',
        'video',
        'galleries',
        'client',
        'category',
        'date',
        'tools',
        'credits',
        'testimonial',
        'impact',
        'status',
        'deleted_at',
        'published_at',
        'meta',
    ];

    // public static function paginateWithFilters($limit)
    // {
    //     return app(Pipeline::class)
    //         ->send(static::query()
    //             ->with(['children.children.children'])
    //             ->whereNull('parent_id'))
    //         ->through([
    //             \App\QueryFilters\SortBy::class,
    //         ])
    //         ->thenReturn()
    //         ->paginate($limit)
    //         ->withQueryString();
    // }

    // public static function allWithFilters()
    // {
    //     return app(Pipeline::class)
    //         ->send(static::query()
    //             ->with(['children.children.children'])
    //             ->whereNull('parent_id'))
    //         ->through([
    //             \App\QueryFilters\SortBy::class,
    //             \App\QueryFilters\Type::class,
    //         ])
    //         ->thenReturn()
    //         ->get();
    // }
}
