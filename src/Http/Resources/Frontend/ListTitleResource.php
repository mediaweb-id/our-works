<?php

namespace AcitJazz\Article\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ListTitleResource extends JsonResource
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
        ];
    }
}
