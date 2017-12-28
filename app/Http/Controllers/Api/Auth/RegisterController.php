<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'birth_date' => 'required|date',
            'use_time' => 'required|numeric'
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt('name')
        ]);

        $date = Carbon::parse(request('birth_date'));

        $user->birth_date = $date;
        $user->dni = request('dni');
        $user->state = request('state');
        $user->sex = request('sex');
        $isWorking = request('working');
        if ($isWorking == 'true') {
            $user->working = 1;
        } else if ('false') {
            $user->working = 0;
        }
        $user->use_time = request('use_time');

        if ($user->save()) {
            return response()->json([
                'message' => 'Ya puede ingresar',
                'success' => [
                    'status' => 'create',
                    'name' => $user->name,
                    'email' => $user->email,
                    'token' => $user->token
                ]
            ]);
        }

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
