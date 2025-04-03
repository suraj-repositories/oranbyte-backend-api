<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalExperience;
use Illuminate\Http\Request;

class ProfessionalExperienceController extends Controller
{
    //
    public function index(){
        try {
            return response()->json(ProfessionalExperience::all());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch professional experiences',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
