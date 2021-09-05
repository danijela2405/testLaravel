<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ReservationResource;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            return response()->json('Only a logged in user is allowed here!', 403);
        }

        if ($user->role === 'owner') {
            return ReservationResource::collection(Reservation::all());
        }

        return ReservationResource::collection(Reservation::where('user_id', $user->id)->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'pick_up_date' => 'required|date|after:now',
                'product_id' => 'required',
            ]
        );

        $user = Auth::user();

        if (!$user instanceof User) {
            return response()->json('Only a logged in user is allowed here!', 403);
        }

        $data = $request->all();

        $reservation = new Reservation($data);

        $reservation->user_id = $user->id;

        $reservation->save();

        $product = Product::find($data['product_id']);

        if ($product->quantity > 0) {
            $product->quantity -= 1;
        } else {
            return response()->json('No more stock!', 400);
        }


        $product->save();

        return new ReservationResource($reservation);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        if ($response = $this->isUserAllowedToView(Reservation::class)) {
            return $response;
        }

        return new ReservationResource(Reservation::findOrFail($reservation->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate(
            [
                'pick_up_date' => 'required|date|after:now'
            ]
        );

        $user = Auth::user();

        if (!$user instanceof User) {
            return response()->json('Only a logged in user is allowed here!', 403);
        }



        $data = $request->all();

        $reservation->pick_up_date = $data['pick_up_date'];

        $reservation->save();

        return new ReservationResource($reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        if ($response = $this->isUserAllowedToDelete(Reservation::class)) {
            return $response;
        }

        $reservation->delete();

        return response()->json('Successfully deleted', 200);

    }
}
