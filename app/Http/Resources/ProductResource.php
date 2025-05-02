<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => $this->price,
            'stock'          => $this->stock,
            'image'          => $this->image ? asset('storage/' . $this->image) : null,
            'category'       => new CategoryResource($this->whenLoaded('category')),
            'sub_category'   => new SubCategoryResource($this->whenLoaded('subCategory')),
            'raw_material'   => $this->raw_material,
            'created_at'     => $this->created_at?->toDateTimeString(),
            'updated_at'     => $this->updated_at?->toDateTimeString(),
        ];
    }
}
