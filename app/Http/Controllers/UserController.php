<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function cria(Request $request)
    {
        $user = User::firstOrCreate($request->all());

        return response()->json(['user' => $user], 200);
    }
}
