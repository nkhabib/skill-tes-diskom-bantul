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
        return [
            "product_id" => $this->product_id,
            "product_name" =>  $this->product_name,
            "supplier_id" => $this->supplier_id,
            "category_id" => $this->category_id,
            "unit_price" => $this->unit_price,
            "units_in_stock" => $this->units_in_stock,
            "category_name" => $this->category_name,
            "supplier_name" => $this->company_name

        ];
    }
}
