<?php

namespace App\Http\Controllers\Api;

use App\Application;
use App\Historic;
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
            'state_use' => 'required'
        ]);

        $apps = request('state_use');

        $user = User::whereToken(request('token'))->firstOrFail();

        $appOrder = array();

        foreach ($apps as $app) {
            if (count(Application::where('name_application', '=', $app['name_application'])->get()) > 0) {
                $appFind = Application::where('name_application', '=', $app['name_application'])->first();
                $useTime = $app['use_time'];
                $quantity = $app['quantity'];
                $lastUseTime = Carbon::parse($app['last_use_time'])->toDateTimeString();
                $created_at = Carbon::parse($app['created_at'])->toDateTimeString();
                $updated_at = Carbon::parse($app['updated_at'])->toDateTimeString();

                if (!$this->updateApplication($appFind, $user, $useTime, $quantity, $lastUseTime, $updated_at)) {
                    $appFind->users()->attach(
                        $user->id, [
                            'time_use' => $useTime,
                            'quantity' => $quantity,
                            'last_use_time' => $lastUseTime,
                            'created_at' => $created_at,
                            'updated_at' => $updated_at
                    ]);
                }

                $appOrder[] = ($appFind->users()
                    ->wherePivot('user_id', '=',$user->id)
                    ->wherePivot('time_use', '=', $useTime)
                    ->wherePivot('last_use_time', '=', $lastUseTime)
                    ->first()->pivot);
            }
        }

        return response()->json([
            'message' => 'Actualizado',
            'app_order' => $appOrder
        ]);
    }

    public function updateApplication(Application $app, User $user, $useTime, $quantity, $lasUseTime, $updated_at)
    {
        $yesterday = new Carbon('yesterday');
        $now = $yesterday->addDay();

        if ($app->users()
                ->wherePivot('created_at', '>', $now)
                ->updateExistingPivot($user->id, ['app_id' => $app->id]) == 1) {
            try {
                foreach ($user->applications($app->id)->get() as $findApp) {

                    if ($now < $findApp->pivot->created_at) {
                        /**
                         * if there is update it will be 1 and if it finds the same value it will be 0
                         */
                        $quantities = $findApp->users()
                            ->wherePivot('user_id', '=', $user->id)
                            ->wherePivot('created_at', '>', $now)
                            ->first()->pivot->quantity;

                        if ($findApp->users()
                            ->wherePivot('created_at', '>', $now)
                            ->updateExistingPivot($user->id, ['time_use' => $useTime,
                                'quantity' => $quantities + $quantity,
                                'last_use_time' => $lasUseTime,
                                'updated_at' => $updated_at]) >= 0) {
                            return true;
                        }
                    }
                }
            } catch(Exception $e) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function putHistoric(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'historic_state'
        ]);

        $user = User::whereToken(request('token'))->firstOrFail();

        $receivedHistory = request('historic_state');

        $yesterday = new Carbon('yesterday');
        $now = $yesterday->addDay();

        $created_at = Carbon::parse($receivedHistory['created_at'])->toDateTimeString();
        $nameTop = $receivedHistory['app_top'];
        $quantity = $receivedHistory['quantity_app_use'];
        $timeUse = $receivedHistory['time_use'];

        if ($findHistoric = Historic::where([
            ['user_id', $user->id],
            ['created_at', '>', $now]])->first()) {

            $historic = Historic::where([
                ['user_id', $user->id],
                ['created_at', '>', $now]])->first();

            $historic->app_top = $nameTop;
            $historic->quantity_app_use = $quantity;
            $historic->time_use = $timeUse;

            if ($historic->save()) {
                return response()->json([
                    'message' => 'Actualizado',
                    'historic_order' => $historic
                ]);
            }

        } else {
            $historic = new Historic();

            $historic->user_id = $user->id;
            $historic->app_top = $nameTop;
            $historic->quantity_app_use = $quantity;
            $historic->time_use = $timeUse;
            $historic->created_at = $created_at;
            $historic->updated_at = $receivedHistory['updated_at'];

            $historic->save();

            return response()->json([
                'message' => 'Registrado',
                'historic_order' => $historic
            ]);
        }

        return response()->json([
            'message' => 'Error',
            'historic_order' => $historic
        ]);

    }

    public function createProfile(Request $request)
    {
        $this->validate($request, [
            'birth_date' => 'required|date',
            'dni' => 'required',
            'use_time' => 'required|numeric'
        ]);

        $user = User::where('email', '=', request('email'))->first();

        $date = Carbon::parse(request('birth_date'));

        $user->birthDate = $date;
        $user->dni = request('dni');
        $user->state = request('state');
        $user->sex = request('sex');
        $user->isWorking = request('working');
        $user->useTime = request('use_time');

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

    public function getAppAll()
    {
        $apps = Application::all();

        return response()->json([
           'applications' => $apps
        ]);
    }


}
