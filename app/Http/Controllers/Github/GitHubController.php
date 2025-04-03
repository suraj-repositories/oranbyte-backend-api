<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use App\Services\GithubServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Firebase\JWT\JWT;

class GitHubController extends Controller
{
    protected $githubService;

    public function __construct(GithubServiceInterface $githubService)
    {
        $this->githubService = $githubService;
    }
    /**
     * Handle GitHub OAuth callback.
     */
    public function handleCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $token = $githubUser->token;

        $response = Http::withToken($token)->get('https://api.github.com/user/repos');

        return response()->json($response->json());
    }

    /**
     * Fetch repositories using GitHub App authentication.
     */
    public function fetchRepositories()
    {
        try{
            return $this->githubService->getRepositories();
        }   catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch repositories',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch Languages
     */

    public function fetchLanguages(){
        try{
            return $this->githubService->getAllLanguages();
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch languages',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
