<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use App\Services\GithubServiceInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $githubService;

    public function __construct(GithubServiceInterface $githubService)
    {
        $this->githubService = $githubService;
    }
    //

    /**
     * Fetch Projects
     */

    public function fetchProjects(Request $request)
    {
        try{
            if($request->has('withImage')){
                return response()->json($this->githubService->getProjects($request->withImage));
            }
            return response()->json($this->githubService->getProjects());
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch projects',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchPopularProjects(Request $request)
    {
        if($request->has('withImage')){
            return response()->json($this->githubService->getPopularProjects($request->withImage));
        }
        return response()->json($this->githubService->getPopularProjects());
    }

    public function fetchProjectById($id)
    {
        try{
            return response()->json($this->githubService->getProjectById($id));
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch project',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchProjectLanguages($id)
    {
        try{
            return response()->json($this->githubService->getProjectLanguages($id));
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch project languages',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchReadmeContent($id)
    {
        try{
            return response()->json($this->githubService->getRepositoryReadme($id));
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch readme content',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function fetchProfileReadmeContent()
    {
        try{
            return response()->json($this->githubService->getProfileReadmeContent());
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch readme content',
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
