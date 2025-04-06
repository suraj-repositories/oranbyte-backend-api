<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use Illuminate\Http\Request;

class AppConfigController extends Controller
{
    //
    public function index()
    {
        $configs = AppConfig::all();
        return response()->json($configs);
    }
}
