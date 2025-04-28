<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Subscriber;
use App\Models\Technology;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    //
    public function index(){
        return response()->json([
            'status' => 'success',
            'message' => 'Stats retrieved successfully',
            'data' => [
                'projects' => Project::count(),
                'technologies' => Technology::count(),
                'hours_of_support' => round(abs(Carbon::now()->diffInHours(Carbon::createFromFormat('Y-m-d H:i:s', '2025-04-22 17:16:27')))),
                'subscribers' => Subscriber::count(),
            ]
        ]);
    }
}
