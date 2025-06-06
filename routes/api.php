<?php

use App\Http\Controllers\AppConfigController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\Github\GitHubController;
use App\Http\Controllers\Github\ProjectController;
use App\Http\Controllers\ProfessionalExperienceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('educations', EducationController::class);
Route::apiResource('experience', ProfessionalExperienceController::class);
Route::apiResource('app-configs', AppConfigController::class);
Route::apiResource('contact', ContactController::class);
Route::apiResource('social-media', SocialMediaController::class);
Route::apiResource('subscribe', SubscriberController::class);
Route::apiResource('skills', SkillController::class);

Route::apiResource('terms', TermController::class);
Route::get('/term/latest', [TermController::class, 'latestTerm']);
Route::get('/stats', [StatsController::class, 'index']);


Route::get('/admin', [UserController::class, 'admin']);
Route::get('/languages', [GitHubController::class, 'fetchLanguages']);

Route::get('/repositories', [GitHubController::class, 'fetchRepositories']);
Route::get('/projects', [ProjectController::class, 'fetchProjects']);
Route::get('/project/readme', [ProjectController::class, 'fetchProfileReadmeContent']);
Route::get('/projects/popular', [ProjectController::class, 'fetchPopularProjects']);
Route::get('/project/{projectname}', [ProjectController::class, 'fetchProjectByName']);
Route::get('/project/{projectname}/languages', [ProjectController::class, 'fetchProjectLanguages']);
Route::get('/project/{projectname}/readme', [ProjectController::class, 'fetchReadmeContent']);
