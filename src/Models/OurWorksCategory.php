<?php

namespace MediaWebId\OurWorks\Models;

use App\Traits\GetSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class OurWorksCategory extends Model {

    use GetSet;

    protected $table = "ourworks_categories";
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
