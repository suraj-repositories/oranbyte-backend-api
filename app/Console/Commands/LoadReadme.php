<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Readme;
use App\Services\GithubServiceInterface;
use Illuminate\Console\Command;

class LoadReadme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-readme';

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
     */
    public function handle()
    {
        //
        $projects = Project::get();

        $this->info('Fetching Readme from GitHub...');

        foreach ($projects as $project) {
            $this->info('Fetching Readme for project: ' . $project->name);
            try {
                $readme = $this->githubService->getRepositoryReadme($project->repository_id);
                if($readme){
                    Readme::updateOrCreate(
                        ['project_id' => $project->id],
                        ['content' => $readme]
                    );
                    $this->info('Readme fetched and saved for project: ' . $project->name);
                }else{
                    $this->error('No readme found for project: ' . $project->name);
                }

            } catch (\Exception $e) {
                $this->error('Failed to fetch readme : ' . $e->getMessage());
                continue;
            }
        }


    }
}
