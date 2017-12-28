<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.application.application', [
            'applications' => $applications
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'relevance' => 'required|integer',
            'image' => 'required|max:255',
            'description' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($findApp = $request->input('id') != null) {
            $apl = Application::find($request->input('id'));
            $message = 'Se ha actualizado correctamente la aplicación';
        } else {
            $apl = new Application();
            $message = 'Se ha creado correctamente la aplicación';
        }

        $apl->name_application = $request->input('name');
        $apl->relevance = $request->input('relevance');
        $apl->image = $request->input('image');
        $apl->description = $request->input('description');

        if ($apl->save()) {
            return redirect()->to(route('application.index'))->with([
                'message' => $message,
                'state' => 'Ok'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Error al guardar',
            'state' => 'Error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        $applications = Application::orderBy('created_at', 'desc')->paginate(12);

        return view('admin.application.application', [
            'message' => 'Editar',
            'findApp' => $application,
            'applications' => $applications
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->back()->with([
            'message' => 'Se eliminó el registro correctamente',
            'status' => 'Ok'
        ]);
    }

    public function showStatistics()
    {
        $applications = Application::all();

        return view('admin.statistics', [
            'applications' => $applications
        ]);
    }
}
