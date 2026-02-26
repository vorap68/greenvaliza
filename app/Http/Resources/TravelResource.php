<?php

namespace App\Http\Resources;

use App\Models\Posts\TravelTable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
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
            "description" => $this->description,// только для постови постов-таблиц из главного меню
            "content" => $this->content,
             "is_visual" => $this->is_visual,
              'image' => $this->imageName,
            'table_id' => $this->table_id, // только для постов внутри таблицы
              // только для админки, для вывода таблицы всех постов
              'sense' => $this->table_id ? TravelTable::select('title')->where('id', $this->table_id)->value('title') : 'SinglePost',   
           
        ];
    }
}
