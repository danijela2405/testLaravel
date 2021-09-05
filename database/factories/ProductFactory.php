<?php

namespace Database\Factories;

use App\Models\Money;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\HttpFoundation\Request;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'quantity' => $this->faker->numberBetween(100,200),
            'price_id' => Money::factory()->create()->id,
            'store_id' => 1
        ];
    }

    public function createFromRequest(array $data, Store $store)
    {
        $productAttributes = $data['product_attributes'];
        $priceArray = $data['price'];

        unset($data['product_attributes'], $data['price']);

        $product = new Product($data);

        $price = $product->price()->create($priceArray);

        $product->price_id = $price->id;

        $productAttributesToPersist = [];
        foreach ($productAttributes as $productAttribute) {
            $productAttribute['product_id'] = $product->id;
            $productAttributesToPersist[] = $productAttribute;
        }

        $product->store_id = $store->id;

        $product->save();
        $price->save();

        $attributes = $product->productAttributes()->createMany($productAttributesToPersist);

        foreach ($attributes as $productAttribute) {
            $productAttribute->save();
        }

        return $product;
    }

    public function updateFromRequest(array $data, Product $product)
    {

        unset($data['product_attributes'], $data['price']);

        if (isset($data['name'])) {
            $product->name = $data['name'];
        }

        if (isset($data['quantity'])) {
            $product->name = $data['name'];
        }

        $price = $product->price()->get();
        if (isset($data['price'])) {
            $price->currency = $data['price']['currency'];
            $price->value = $data['price']['value'];
            $price->save();
        }


        if (isset($data['product_attributes'])) {
            $productAttributesToPersist = [];
            foreach ($data['product_attributes'] as $productAttribute) {
                if (isset($productAttribute['id'])) {
                    $productAttributeFromDb = ProductAttribute::find($productAttribute['id']);
                    $productAttributeFromDb->name = $productAttribute['name'];
                    $productAttributeFromDb->value = $productAttribute['value'];
                    $productAttributeFromDb->save();
                } else {
                    $productAttribute['product_id'] = $product->id;
                    $productAttributesToPersist[] = $productAttribute;
                }
            }
        }

        $product->save();

        $attributes = $product->productAttributes()->createMany($productAttributesToPersist);

        foreach ($attributes as $productAttribute) {
            $productAttribute->save();
        }

        return $product;
    }
}
