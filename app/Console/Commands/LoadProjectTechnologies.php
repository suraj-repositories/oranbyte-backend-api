<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\ProjectTechnology;
use App\Models\Technology;
use App\Services\GithubServiceInterface;
use Illuminate\Console\Command;

class LoadProjectTechnologies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-project-technologies';

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
        //getProjectLanguages

        $projects = Project::get();

        $this->info('Fetching Readme from GitHub...');

        foreach ($projects as $project) {
            $this->info('Fetching Readme for project: ' . $project->name);
            try {
                $languages = $this->githubService->getProjectLanguages($project->repository_id);
                if($languages){
                    foreach ($languages as $language => $percentage) {

                        $dbLanguage = Technology::updateOrCreate(
                            ['name' => $language],
                            ['name' => $language]
                        );

                        ProjectTechnology::updateOrCreate(
                            ['project_id' => $project->id, 'technology_id' => $dbLanguage->id],
                            ['percentage' => $percentage]
                        );
                    }
                }
                $this->info('Languages fetched successfully for project: ' . $project->name);
            } catch (\Exception $e) {
                $this->error('Failed to fetch readme : ' . $e->getMessage());
                continue;
            }
        }

    }
}
