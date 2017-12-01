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
           'email' => 'required|unique:users,email',
           'password' => 'required|min:6|confirmed',
           'password_confirmation'  => 'required'
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt('password')
        ]);

        return response()->json([
            'message' => 'Cuenta creada satiffactoriamente',
            'success' => [
                'status' => 'create',
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at]
        ]);
    }
}
