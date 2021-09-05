<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * @return ProductResource
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($response = $this->isUserAllowedToCreate(Product::class)) {
            return $response;
        }

        $request->validate(
            [
                'name' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                'product_attributes' => 'array|min:2',
            ]
        );

        $user = Auth::user();
        $store = $user->stores()->first();

        $data = $request->all();

        $product = Product::factory()->createFromRequest($data, $store);

        return new ProductResource($product);
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource(Product::findOrFail($product->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($response = $this->isUserAllowedToUpdate(Product::class)) {
            return $response;
        }

        $request->validate(
            [
                'name' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                'product_attributes' => 'array|min:2',
            ]
        );

        $data = $request->all();

        $product = Product::factory()->updateFromRequest($data, $product);

        return new ProductResource($product);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        if ($response = $this->isUserAllowedToDelete(Product::class)) {
            return $response;
        }

        $product->delete();

        return response()->json('Successfully deleted', 200);
    }
}
