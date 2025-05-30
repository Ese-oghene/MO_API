<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
        'id'         => $this->id,
        'product_id' => $this->product_id,
        'quantity'   => $this->quantity,
        'price'      => $this->price,
        'subtotal'   => $this->quantity * $this->price,
        'product'    => [
            'id'       => $this->product->id,
            'name'     => $this->product->name,
           'category' => [
                'id' => $this->product->category->id ?? null,
                'name' => $this->product->category->name ?? 'N/A',
            ],
        ],
    ];

    }
}
