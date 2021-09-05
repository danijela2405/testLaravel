<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function isUserAllowedToUpdate()
    {
        $user = Auth::user();

        if(!$user instanceof User){
            return response()->json('Only a logged in user is allowed here!', 403);
        }

        if ($user->cant('update')) {
            return response()->json('You are not allowed to do this action', 403);
        }

        return null;
    }
}
