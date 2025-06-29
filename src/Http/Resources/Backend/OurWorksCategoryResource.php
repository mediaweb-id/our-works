<?php

namespace MediaWebId\OurWorks\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OurWorksCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'summary' => $this->summary,
            'status' => $this->status,
            'meta'=> $this->meta ?? [
               'title' =>  '',
               'description' =>  '',
               'image' =>  '',
            ],
            'published_at' => $this->published_at ? Carbon::parse($this->published_at)->format('Y-m-d H:i') : null,
        ];
    }
}
