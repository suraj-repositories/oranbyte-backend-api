<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalExperience;
use Illuminate\Http\Request;

class ProfessionalExperienceController extends Controller
{
    //
    public function index()
    {
        try {
            return ProfessionalExperience::with('technologies:name,id')->get()
                ->map(function ($exp) {
                    return [
                        'id' => $exp->id,
                        'user_id' => $exp->user_id,
                        'job_title' => $exp->job_title,
                        'company' => $exp->company,
                        'location' => $exp->location,
                        'start_date' => $exp->start_date,
                        'end_date' => $exp->end_date,
                        'currently_working' => $exp->currently_working,
                        'description' => $exp->description,
                        'created_at' => $exp->created_at,
                        'updated_at' => $exp->updated_at,
                        'technologies' => $exp->technologies->pluck('name'),
                    ];
                });
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch professional experiences',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
