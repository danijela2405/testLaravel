<?php

namespace App\Http\Resources;

use App\Models\Money;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = parent::toArray($request);

        $product['price'] = Money::find($product['price_id']);

        $productAttributes = ProductAttribute::where('product_id',$product['id'])->get();

        $product['product_attributes'] = $productAttributes;

        unset($product['price_id']);

        return $product;
    }
}
