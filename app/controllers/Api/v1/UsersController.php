<?php

namespace Api\v1;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends \BaseController
{
     public function find($username)
     {
         try {
            $user = \User::where('username', $username)->select('username')->firstOrFail();
         } catch (ModelNotFoundException $e) {
            return \Response::make('User not found', 404);
         }
         return \Response::json($user->toArray());
     }
}