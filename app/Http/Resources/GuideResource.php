<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'imageName' => $this->imageName,
            'imageExten' => $this->imageExten,
             "date" => $this->created_at->format('Y-m-d'),
             "type" => "posts",
              "content" => $this->content,
          "is_visual" => $this->is_visual,
           'image' => $this->imageName,
           
        ];
    }
}
