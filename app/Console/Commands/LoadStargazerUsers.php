<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\User;
use App\Services\GithubServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoadStargazerUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-stargazer-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     *
     */
    public function handle()
    {
        //
        $projects = Project::get();

        $this->info('Fetching stargazer users from GitHub...');

        foreach ($projects as $project) {
            $this->info('Fetching stargazer users for project: ' . $project->name);

            if(!$project->urls){
                $this->error('No project URLs found for project: ' . $project->name);
                continue;
            }

            $stargazers_url = $project->urls->where('type', 'stargazers')->first();
            if (!$stargazers_url) {
                $this->error('No stargazers URL found for project: ' . $project->name);
                continue;
            }
            $stargazers_url = $stargazers_url->url;
            try {
                $stargazers = $this->githubService->getStargazers($stargazers_url);

                if (empty($stargazers)) {
                    $this->error('No stargazer users found for project: ' . $project->name);
                    continue;
                }
                foreach($stargazers as $stargazer){

                    User::updateOrCreate(
                    [
                        'github_id' => $stargazer['id'],
                    ],
                    [
                        'name' => $stargazer['login'],
                        'avatar' => $stargazer['avatar_url'],
                        'username' => $stargazer['login'],
                        'email' => $stargazer['login'] . '@'. strtolower(config('app.name')) .'.com',
                        'password' => Hash::make(Str::random(10)),
                        'role' => 'GITHUB_USER',

                    ]);
                    $this->info('Stargazer user: ' . $stargazer['login'] . ' added/updated.');

                }

            } catch (\Exception $e) {
                $this->error('Failed to fetch stargazer users: ' . $e->getMessage());
                continue;
            }
        }

    }
}
