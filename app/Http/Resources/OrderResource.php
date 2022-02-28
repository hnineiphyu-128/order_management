<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $baseurl = URL('/');
        return [
            "order_id" => $this->id,
            "voucher_no" => $this->voucher_no,
            "total" => $this->total,
            "status" => $this->status,
            "user" => new UserResource(User::find($this->user_id)),
            'products' => ProductResource::collection($this->products),
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y')

        ];
    }
}
