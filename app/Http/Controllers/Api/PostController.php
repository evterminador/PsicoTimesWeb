<?php

namespace App\Http\Controllers\Api;

use App\Application;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;

class PostController extends Controller
{

    public function putAll(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'stateUse' => 'required'
        ]);

        $apps = request('stateUse');

        $user = User::whereToken(request('token'))->firstOrFail();

        foreach ($apps as $app) {
            if (count(Application::where('nameApplication', '=', $app['nameApplication'])->get()) > 0) {
                $appFind = Application::where('nameApplication', '=', $app['nameApplication'])->first();
                if (!$this->updateApplication($appFind, $user)) {
                    $appFind->users()->attach(
                        $user->id, [
                        'timeUse' => $app['useTime'],
                        'quantity' => $app['quantity'],
                        'lastUseTime' => Carbon::parse($app['lastUseTime'])
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Actualizado',
            'appOrder' => $apps
        ]);
    }

    public function updateApplication(Application $app, User $user)
    {
        if ($app->users()->updateExistingPivot($user->id, ['id_app' => $app->id]) == 1) {
            try {
                $quantities = $user->applications($app->id)->first()->pivot->quantity;

                if ($app->users()->updateExistingPivot($user->id, ['quantity' => ++$quantities]) == 1) {
                    true;
                }
            } catch(Exception $e) {
                return true;
            }
            return true;
        } else {
            return false;
        }
    }

    public function createProfile(Request $request)
    {
        $this->validate($request, [
            'birthDate' => 'required|date',
            'useTime' => 'required|numeric'
        ]);

        $user = User::where('email', '=', request('email'))->first();

        $date = Carbon::parse(request('birthDate'));

        $user->birthDate = $date;
        $user->state = request('occupation');
        $user->sex = request('sex');
        $user->isWorking = request('isWorking');
        $user->useTime = request('useTime');

        if ($user->save()) {
            return response()->json([
                'message' => 'Actualizado',
                'success' => [
                    'update' => 'true'
                ]
            ]);
        }

        return response()->json([
            'message' => 'No se ha podido registrar su perfil',
            'error'
        ]);
    }
}
