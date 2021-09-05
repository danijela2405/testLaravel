<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreCollectionResource;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * @return StoreCollectionResource
     */
    public function index()
    {
        return new StoreCollectionResource(Store::all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
            ]
        );

        $store = new Store(
            [
                'name' => $request->get('name'),
            ]
        );

        $store->save();

        return response()->json(
            [
                'message' => 'Store successfully saved',
                'store' => $store,
            ],
            201
        );
    }

    /**
     * @param $id
     * @return StoreResource
     */
    public function show($id)
    {
        return new StoreResource(Store::find($id));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($response = $this->isUserAllowedToUpdate(Store::class)) {
            return $response;
        }

        $request->validate([
            'name'=>'required'
        ]);

        $store = Store::find($id);
        $store->name =  $request->get('name');
        $store->save();

        return response()->json($store, 200);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $store = Store::find($id);
        $store->delete();

        return response()->json('Successfully deleted', 200);

    }
}
