<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    //
    public function index()
    {
        try {
            $userId = User::where('role', 'ADMIN')->value('id');
            return Education::where('user_id', $userId)->orderByDesc('id')->get();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch educations',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
