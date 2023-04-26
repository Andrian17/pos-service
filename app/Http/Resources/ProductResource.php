<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
        $pathImage = '/storage/products/';
        $category = collect($this->category)->except(["created_at", "updated_at"]);
        return [
            "id" => $this->id,
            "SKU" => $this->SKU,
            "name" => $this->name,
            "stock" => $this->stock,
            "price" => $this->price,
            "image" => $this->image ? $request->getSchemeAndHttpHost() . $pathImage . $this->image : null,
            "category" => $category,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
