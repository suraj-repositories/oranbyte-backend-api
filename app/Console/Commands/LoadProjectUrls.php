<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUrl;
use App\Services\GithubServiceInterface;
use Illuminate\Console\Command;

class LoadProjectUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-project-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load GitHub URLs for all projects linked to repositories';

    /**
     * GitHub service interface.
     *
     * @var GithubServiceInterface
     */
    protected $githubService;

    /**
     * Create a new command instance.
     *
     * @param  GithubServiceInterface  $githubService
     * @return void
     */
    public function __construct(GithubServiceInterface $githubService)
    {
        parent::__construct();
        $this->githubService = $githubService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching repositories from GitHub...');

        try {
            $repos = $this->githubService->getRepositories();
        } catch (\Exception $e) {
            $this->error('Failed to fetch repositories: ' . $e->getMessage());
            return;
        }

        $admin = User::where('role', 'ADMIN')->first();

        if (!$admin) {
            $this->error('No ADMIN user found.');
            return;
        }

        foreach ($repos as $repo) {
            $project = Project::where('repository_id', $repo['id'])->first();

            if (!$project) {
                $this->warn('No project found for repository ID: ' . $repo['id']);
                continue;
            }

            $urlTypes = $this->getGithubUrlTypes($repo['owner']['login'], $repo['name']);

            foreach ($urlTypes as $type => $url) {
                ProjectUrl::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'type' => $type,
                    ],
                    [
                        'url' => $url,
                    ]
                );

                $this->info("[$type] URL saved for project ID: {$project->id}");
            }
        }

        $this->info('All project URLs loaded successfully.');
    }

    /**
     * Get the list of GitHub URL types for a given repo.
     *
     * @param string $owner
     * @param string $repo
     * @return array
     */
    protected function getGithubUrlTypes(string $owner, string $repo): array
    {
        return [
            'github'        => "https://github.com/{$owner}/{$repo}",
            'stargazers'    => "https://api.github.com/repos/{$owner}/{$repo}/stargazers",
            'watchers'      => "https://api.github.com/repos/{$owner}/{$repo}/subscribers",
            'forks'         => "https://api.github.com/repos/{$owner}/{$repo}/forks",
            'issues'        => "https://api.github.com/repos/{$owner}/{$repo}/issues",
            'pull_requests' => "https://api.github.com/repos/{$owner}/{$repo}/pulls",
            'commits'       => "https://api.github.com/repos/{$owner}/{$repo}/commits",
            'contributors'  => "https://api.github.com/repos/{$owner}/{$repo}/contributors",
            'releases'      => "https://api.github.com/repos/{$owner}/{$repo}/releases",
            'readme'        => "https://api.github.com/repos/{$owner}/{$repo}/readme",
        ];
    }
}
