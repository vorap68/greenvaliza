<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdviceResource extends JsonResource
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
            'slug' => $this->slug,
            "date" => $this->created_at->format('Y-m-d'),
            "type" => $this->type,
            "imageName"=>$this->imageName,
            "imageExten"=>$this->imageExten,
            "description" => $this->description,
            "content" => $this->content,
             "is_published" => $this->is_published,
             "is_visual" => $this->is_visual ,
              'image' => $this->imageName.'_small.'.$this->imageExten,
           
        ];
    }
}
