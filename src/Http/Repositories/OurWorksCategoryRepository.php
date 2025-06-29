<?php

namespace MediaWebId\OurWorks\Http\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use MediaWebId\OurWorks\Models\OurWorks;
use MediaWebId\OurWorks\Models\OurWorksCategory;

class OurWorksCategoryRepository
{
    public const CACHE_KEY = 'OURWORKS_CATEGORY';

    public function pluck($name, $id)
    {
        $key = "pluck.{$name}.{$id}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks_category'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($name, $id) {
            return OurWorksCategory::pluck($name, $id);
        });
    }


    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks_category'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return OurWorksCategory::allWithFilters();
        });
    }

    public function findBySlug($slug)
    {
        $key = "findBySlug.{$slug}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks_category'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($slug) {
            return OurWorksCategory::findBySlug($slug);
        });
    }

    public function findByTemplate($template)
    {
        $key = "findByTemplate.{$template}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks_category'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($template) {
            return OurWorksCategory::where('template',$template)->latest('created_at')->first();
        });
    }

    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks_category'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return OurWorksCategory::latest('created_at')->paginate($number);
        });
    }

    public function paginateTrash($number)
    {
        request()->merge(['trash' => '1']);
        $keys = $this->requestValue();
        $key = "paginateTrash.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks_category'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return OurWorksCategory::latest('deleted_at')->paginate($number);;
        });
    }

    public function countTrash()
    {
        $key = 'countTrash';
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks_category'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return OurWorksCategory::onlyTrashed()->count();
        });
    }

    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY.".$key";
    }

    private function requestValue()
    {
        return http_build_query(request()->all(), '', '.');
    }
}
