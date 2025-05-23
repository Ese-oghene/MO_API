<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id'    => $this->user_id,
            'total'      => $this->total,
            'status'     => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
                'user'       => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
                'phone_no'     => $this->user->phone_no,
            ],
            'order_items'      => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
