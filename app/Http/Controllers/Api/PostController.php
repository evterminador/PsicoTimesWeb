<?php

namespace App\Http\Controllers\Api;

use App\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function __construct()
    {

    }

    public function putAll(Request $request)
    {
        dd($request-all());
    }
}
