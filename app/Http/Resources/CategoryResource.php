<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'  => $this->id,
            'name' => $this->trans_name,
            'image' => $this->image && $this->image->path
                ? asset('storage/' . $this->image->path)
                : null,
            'description' => $this->trans_description
        ];
    }
}
