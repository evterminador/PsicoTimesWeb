<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|unique:users,name',
           'email' => 'required|email|unique:users,email',
           'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt('password')
        ]);

        return response()->json([
            'message' => 'Cuenta creada satisfactoriamente',
            'success' => [
                'status' => 'create',
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->token
            ]
        ]);
    }
}
