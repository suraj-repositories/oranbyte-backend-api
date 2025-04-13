<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\User;
use App\Services\GithubServiceInterface;
use Illuminate\Console\Command;

class LoadProjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-project-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load projects from GitHub';

    /**
     * The GitHub service instance.
     *
     * @var \App\Services\GithubServiceInterface
     */
    protected $githubService;

    /**
     * Create a new command instance.
     *
     * @param  \App\Services\GithubServiceInterface  $githubService
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
        $this->info('Fetching projects from GitHub...');

        try {
            $projects = $this->githubService->getProjects(true);
        } catch (\Exception $e) {
            $this->error('Failed to fetch projects: ' . $e->getMessage());
            return;
        }

        $admin = User::where('role', 'ADMIN')->first();

        if (!$admin) {
            $this->error('No ADMIN user found.');
            return;
        }

        $userId = $admin->id;

        foreach ($projects as $project) {
            Project::updateOrCreate(
                [
                    'repository_id' => $project['id'],
                ],
                [
                    'user_id' => $userId,
                    'name' => $project['name'],
                    'description' => $project['description'],
                    'url' => $project['url'],
                    'image' => $project['image'],
                    'language' => $project['language'],
                    'created_at' => $project['created_at'],
                    'updated_at' => $project['updated_at'],
                ]
            );
        }

        $this->info('Projects loaded successfully!');
        $this->info('Total Projects: ' . count($projects));
    }
}
