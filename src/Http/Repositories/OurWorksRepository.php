<?php

namespace MediaWebId\OurWorks\Http\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use MediaWebId\OurWorks\Models\OurWorks;

class OurWorksRepository
{
    public const CACHE_KEY = 'OURWORKS';

    public function pluck($name, $id)
    {
        $key = "pluck.{$name}.{$id}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($name, $id) {
            return OurWorks::pluck($name, $id);
        });
    }


    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return OurWorks::allWithFilters();
        });
    }

    public function findBySlug($slug)
    {
        $key = "findBySlug.{$slug}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($slug) {
            return OurWorks::findBySlug($slug);
        });
    }

    public function findByTemplate($template)
    {
        $key = "findByTemplate.{$template}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($template) {
            return OurWorks::where('template',$template)->latest('created_at')->first();
        });
    }

    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return OurWorks::latest('created_at')->paginate($number);
        });
    }

    public function paginateTrash($number)
    {
        request()->merge(['trash' => '1']);
        $keys = $this->requestValue();
        $key = "paginateTrash.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return OurWorks::latest('deleted_at')->paginate($number);;
        });
    }

    public function countTrash()
    {
        $key = 'countTrash';
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['ourworks'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return OurWorks::onlyTrashed()->count();
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
