<?php


namespace App\Http\Resources;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $reservation = parent::toArray($request);

        $reservation['product'] = new ProductResource(Product::find($reservation['product_id']));

        $reservation['user'] = new UserResource(User::find($reservation['user_id']));

        unset($reservation['product_id'], $reservation['user_id']);

        return $reservation;
    }
}