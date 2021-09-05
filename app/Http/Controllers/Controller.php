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

    protected function isUserAllowedToUpdate($class)
    {
        $user = Auth::user();

        if(!$user instanceof User){
            return response()->json('Only a logged in user is allowed here!', 403);
        }

        if ($user->cant('update', [$user, $class])) {
            return response()->json('You are not allowed to do this action', 403);
        }

        return null;
    }

    protected function isUserAllowedToCreate($class = null)
    {
        $user = Auth::user();

        if(!$user instanceof User){
            return response()->json('Only a logged in user is allowed here!', 403);
        }

        if ($user->cannot('create', $class)) {
            return response()->json('You are not allowed to do this action', 403);
        }

        return null;
    }

    protected function isUserAllowedToDelete($class = null)
    {
        $user = Auth::user();

        if(!$user instanceof User){
            return response()->json('Only a logged in user is allowed here!', 403);
        }

        if ($user->cannot('delete', $class)) {
            return response()->json('You are not allowed to do this action', 403);
        }

        return null;
    }

    protected function isUserAllowedToView($class = null)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            return response()->json('Only a logged in user is allowed here!', 403);
        }

        if ($user->cannot('view', $class)) {
            return response()->json('You are not allowed to do this action', 403);
        }

        return null;
    }
}
